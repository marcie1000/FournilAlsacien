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

function ajouteAuPanier($pdo, $comActuelle, $refP, $qte) {
    try {
        $sql = $pdo->prepare("INSERT INTO QUANTIFIER VALUES('$refP', $comActuelle, $qte);");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
}

function affichage($pdo, $idU) {
    echo '<h1>Vos Commandes</h1>

    <table>
        <tr>    <!-- première ligne du tableau avec en-têtes pour les commandes-->
            <td>Numéro</td>
            <td>Date</td>
            <td>Produits commandés</td>
            <td>Quantité</td>
            <td>Date livraison</td>
        </tr>';
    try {
        $sql = $pdo->prepare("SELECT COMMANDE.idCommande FROM COMMANDE WHERE COMMANDE.idU = '$idU';");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    $row = $sql->fetchAll();
    foreach($row as $key=>$value) {
        $idCommande = $value['idCommande'];
        echo '<tr>';
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
            $sql2 = $pdo->prepare('SELECT PRODUIT.designation, QUANTIFIER.quantite FROM PRODUIT, QUANTIFIER'.
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
        echo '</tr></table>';
    }
}

include("get_commande_form.php");
/* echo var_dump($panier); */
//recherche si une commande est en cours
$comActuelle = getCommandeActuelle($pdo, $idU);
if(null == $comActuelle)
    $comActuelle = creerCommande($pdo, $idU);

foreach($panier as $key => $value) {
    if($value != 0) {
        ajouteAuPanier($pdo, $comActuelle, $key, $value);
    }
}

affichage($pdo, $idU);
?>
