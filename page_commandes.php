<?php
// récupère le numéro de commande actuelle
// renvoie le numéro de la dernière commande créée si elle n'est pas encore validée,
// renvoie null si la dernière commande est validée ou si il n'y a aucune commande
// associée à l'utilisateur.
function getCommandeActuelle($pdo, $idU) {
    try {
        $sql = $pdo->prepare("SELECT MAX(COMMANDE.idCommande) AS 'comActuelle' FROM COMMANDE  WHERE COMMANDE.idU = '$idU';");
        $sql->execute();
        $row = $sql->fetch();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    $comActuelle = $row['comActuelle'];

    if($comActuelle == null)
        return null;

    try {
        $sql = $pdo->prepare("SELECT COMMANDE.validee FROM COMMANDE WHERE COMMANDE.idU = '$idU' AND COMMANDE.idCommande = $comActuelle;");
        $sql->execute();
        $row = $sql->fetch();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    //si la dernière commande est validée, il faut en créer une nouvelle
    if($row['validee'] == 1)
        return null;

    return $comActuelle;
}

function creerCommande($pdo, $idU) {
    try {
        $sql = $pdo->prepare("INSERT INTO COMMANDE VALUES(null, 0, '$idU', null);");
        $sql->execute();
        $row = $sql->fetch();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    // renvoie le nouveau numéro créé
    return getCommandeActuelle($pdo, $idU);
}

// vérifie si une entrée a déjà eu lieu pour ce produit dans le panier
// renvoie la quantité ou null si aucune entrée
function verifieQuantitePanier($pdo, $comActuelle, $refP) {
    try {
        $sql = $pdo->prepare("SELECT QUANTIFIER.quantite FROM QUANTIFIER WHERE QUANTIFIER.idCommande = $comActuelle AND QUANTIFIER.refP = '$refP';");
        $sql->execute();
        $row = $sql->fetch();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    if($row == false)
        return null;
    else
        return $row['quantite'];
}

function supprimeEntreePanier($pdo, $comActuelle, $refP) {
    try {
        $sql = $pdo->prepare("DELETE FROM QUANTIFIER WHERE QUANTIFIER.refP = '$refP' AND QUANTIFIER.idCommande = '$comActuelle';");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
}

function ajouteAuPanier($pdo, $comActuelle, $refP, $qte) {
    //vérifie si le produit est déjà dans le panier

    try {
        $sql = $pdo->prepare("INSERT INTO QUANTIFIER VALUES('$refP', $comActuelle, $qte);");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
}

function affLigneTableau($pdo, $idU, $idCommande) {
    echo '<td>'.$idCommande.'</td>';
    try {
        $sql2 = $pdo->prepare("SELECT COMMANDE.dateCommande FROM COMMANDE WHERE COMMANDE.idU = '$idU';");
        $sql2->execute();
        $row2 = $sql2->fetch();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }

    echo '<td>'.$row2['dateCommande'].'</td>';

    try{
        $sql2 = $pdo->prepare('SELECT PRODUIT.designation, PRODUIT.prix, QUANTIFIER.quantite FROM PRODUIT, QUANTIFIER'.
                              ' WHERE QUANTIFIER.refP = PRODUIT.refP AND QUANTIFIER.idCommande = "'.$idCommande.'";)');
        $sql2->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    $row2 = $sql2->fetchAll();
    echo '<td>';
    foreach($row2 as $key=>$value) {
        echo $value['designation'].'<br>';
    }
    echo '</td><td>';
    foreach($row2 as $key=>$value) {
        echo $value['quantite'].'<br>';
    }
    echo '</td><td>';
    $total = 0;
    foreach($row2 as $key=>$value) {
        echo number_format($value['prix'], 2, ',', '').' €<br>';
        $total += $value['prix'] * $value['quantite'];
    }
    echo '</td><td>'.number_format($total, 2, ',', '').' €</td>';
    echo '<td></td>';
}

// affiche les tableaux des commandes
function affichageTableaux($pdo, $idU, $validees) {
    echo '<table class="tabCommande">
        <tr>    <!-- première ligne du tableau avec en-têtes pour les commandes-->
            <td>Numéro</td>
            <td>Date</td>
            <td>Produits commandés</td>
            <td>Quantité</td>
            <td>Prix unitaire</td>
            <td>Prix total</td>
            <td>Date livraison</td>
        </tr>';
    try {
        $sql = $pdo->prepare("SELECT COMMANDE.idCommande, COMMANDE.validee FROM COMMANDE WHERE COMMANDE.idU = '$idU';");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    $row = $sql->fetchAll();
    foreach($row as $key=>$value) {
        $idCommande = $value['idCommande'];

        if(($validees and $value['validee'] == 1) or (!$validees and $value['validee'] == 0)) {
            echo '<tr>';
            affLigneTableau($pdo, $idU, $idCommande);
            echo '</tr>';
        }
    }
    echo '</table>';
}

function affPageCommandes($pdo, $idU, $mdpU) {

    if($idU == 'visiteur') {
        echo "<div class='errorMsg'><p>Vous devez vous connecter avant d'effectuer des commandes !</p></div>";
        return;
    }

    
    include("get_commande_form.php");
    /* echo var_dump($panier); */
    //recherche si une commande est en cours (panier), en créée une nouvelle si besoin
    $comActuelle = getCommandeActuelle($pdo, $idU);
    if(null == $comActuelle)
        $comActuelle = creerCommande($pdo, $idU);

    //ajoute les éléments sélectionnés sur un formulaire produit au panier
    foreach($panier as $key => $value) {
        if($value == 0) {
            if(verifieQuantitePanier($pdo, $comActuelle, $key) != null)
                supprimeEntreePanier($pdo, $comActuelle, $key);
        }
        elseif($value > 0){
            if(verifieQuantitePanier($pdo, $comActuelle, $key) != null)
                supprimeEntreePanier($pdo, $comActuelle, $key);
            ajouteAuPanier($pdo, $comActuelle, $key, $value);
        }
    }

    echo '<h1>Votre panier</h1>';
    affichageTableaux($pdo, $idU, false);

    echo '<br><form method="post" id="" action="index.php">
    <input class="validerPanier" type="submit" name="validerPanier" value="🛒 Valider votre panier">
    ';
    include("transmettre_info.php");
    echo '</form>';

    echo '<h1>Historique des commandes</h1>';
    affichageTableaux($pdo, $idU, true);
}


?>
