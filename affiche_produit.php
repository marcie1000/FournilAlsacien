<?php

// Cette page sert à afficher les informations des produits dans un tableau
// Affiche une catégorie de produits différente en fonction de la catégorie présente
// dans la variable $codeCat
// exemple :
// si $codeCat = 'PAINS' => la page va afficher les pains, etc

// Notation objet PDO
// PREPARE LA REQUETE
include("page_commandes.php");

// le compte 'visiteur' n'est pas autorisé à effectuer des commandes, il doit se connecter
$enableCommand = true;
if($idU == "visiteur")
    $enableCommand = false;

// Compte le nombre de produits dans la catégorie
$sql = $pdo->prepare('SELECT COUNT(*) AS nombre FROM PRODUIT WHERE PRODUIT.codeCat = "'.$codeCat.'";');

try {
    $sql->execute(); // EXECUTE LA REQUETE
    $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
    // récupère le nombre de produits dans la catégorie
    $nb = $result['nombre'];
}
catch(Exception $e){
    die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
}

echo "<form action='index.php' method='post'>";
// Permet de transmettre de page en page les informations de l'identifiant et du mot de passe
include("transmettre_info.php");
echo "<table class='tabPdt'>";
// Boucle for qui crée une ligne de tableau pour chaque produit de la catégorie
for ($i = 1; $i <= $nb; $i++) {
    // La première lettre du code de la catégorie correspond à la première lettre de refP
    // ainsi on peut afficher tous les produits de la catégorie, par exemple :
    // 'P001', 'P002', 'P003', ...
    $refP = $codeCat[0].'00'.$i;

    try {
        $sql = $pdo->prepare('SELECT prix, poidsP, designation, descriptif, photoP FROM PRODUIT WHERE PRODUIT.refP = "'.$refP.'";');
        $sql->execute();
        $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }

    // affichage de la ligne du tableau :
    echo "<tr>";
    echo '<td class="pdtCell"><h2>'.$result['designation'].'</h2>';
    echo $result['descriptif'].'</td>';
    echo '<td class="poidsCell">Poids : '.$result['poidsP'].'g</td>';
    echo '<td class="imgPdtCell"><img class="imgProduit" src="'.$result["photoP"].'"></td>';

    // récupère les allergènes
    try {
        $sql = $pdo->prepare('SELECT ALLERGENE.denomination, EXISTER.presence, EXISTER.trace FROM ALLERGENE, EXISTER WHERE EXISTER.refP = "'.$refP.'" AND ALLERGENE.id = EXISTER.id;');
        $sql->execute();
        $strPresence = '<strong>Allergènes :</strong> ';
        $strTraces = '<strong>Traces : </strong>';
        while($row = $sql->fetch()){
            if($row['presence'] == 1)
                $strPresence = $strPresence.$row['denomination'].', ';
            elseif($row['trace'] == 1)
                $strTraces = $strTraces.$row['denomination'].', ';
        }
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }

    // affiche les allergènes
    echo '<td class="allergenesCell">';
    echo $strPresence.'<br>'.$strTraces;
    echo '</td>';

    // affiche le prix et la sélection de la quantité
    echo '<td class=prixCell>Prix : '.number_format((float)$result['prix'], 2, ',', '').' €</td>';
    echo '<td class="qteCell">';
    echo '<label for="qte'.$refP.'">Quantité :<label>';
    echo '<input class="qteForm" type="number" step="1" id="qte'.$refP.'" name="qte'.$refP.'"';

    // si le compte est 'visiteur', le choix de la quantité est désactivé
    if(!$enableCommand)
        echo 'disabled="true">';
    // sinon, récupère la quantité précédemment choisie dans le panier, si il y en a
    else {
        $comActuelle = getCommandeActuelle($pdo, $idU);
        if(null == $comActuelle)
            $comActuelle = creerCommande($pdo, $idU);
        $value = verifieQuantitePanier($pdo, $comActuelle, $refP);
        if($value == null)
            $value = 0;
        echo 'value="'.$value.'"';
    }
    echo '</td>';
    echo "</tr>";
}
echo "</table>";
// Pour informer la page index qu'on vient d'ajouter des produits à la commande
echo '<input type="hidden" name="info" value="commande">';
echo '<br><input class="panier" type="submit" value="🛒 Ajouter au panier"';
if(!$enableCommand)
    echo 'disabled="true"';
echo '>';
echo "</form>";

?>
