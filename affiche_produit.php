<?php
// Notation objet PDO
// PREPARE LA REQUETE
include("page_commandes.php");
$enableCommand = true;
if($idU == "visiteur")
    $enableCommand = false;
$sql = $pdo->prepare('SELECT COUNT(*) AS nombre FROM PRODUIT WHERE PRODUIT.codeCat = "'.$codeCat.'";');

/* RELIER LES VALEURS A LA REQUETE
 * $sql->bindValue(':id', $id, PDO::PARAM_STR); // type ENTIER : PARAM_INT

 * $sql->bindValue(':pseudo', $pseudo, PDO::PARAM_STR); // type CHAINE DE CARACTEREE */


$sql->execute(); // EXECUTE LA REQUETE
$result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
$nb = $result['nombre'];
echo "<form action='index.php' method='post'>";
include("transmettre_info.php");
echo "<table class='tabPdt'>";
for ($i = 1; $i <= $nb; $i++) {
    $refP = $codeCat[0].'00'.$i;
    $sql = $pdo->prepare('SELECT prix, poidsP, designation, descriptif, photoP FROM PRODUIT WHERE PRODUIT.refP = "'.$refP.'";');
    $sql->execute();
    $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
    echo "<tr>";
    echo '<td class="pdtCell"><h2>'.$result['designation'].'</h2>';
    echo $result['descriptif'].'</td>';
    echo '<td class="poidsCell">Poids : '.$result['poidsP'].'g</td>';
    echo '<td class="imgPdtCell"><img class="imgProduit" src="'.$result["photoP"].'"></td>';
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
    echo '<td class="allergenesCell">';
    echo $strPresence.'<br>'.$strTraces;
    echo '</td>';
    echo '<td class=prixCell>Prix : '.number_format((float)$result['prix'], 2, ',', '').' €</td>';
    echo '<td class="qteCell">';
    echo '<label for="qte'.$refP.'">Quantité :<label>';
    echo '<input class="qteForm" type="number" step="1" id="qte'.$refP.'" name="qte'.$refP.'"';
    if(!$enableCommand)
        echo 'disabled="true">';
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
