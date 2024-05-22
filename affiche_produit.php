<?php
// Notation objet PDO
// PREPARE LA REQUETE
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
    $sql = $pdo->prepare('SELECT prix, poidsP, designation, descriptif, photoP FROM PRODUIT WHERE PRODUIT.refP = "'.$codeCat[0].'00'.$i.'";');
    $sql->execute();
    $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
    echo "<tr>";
    echo '<td class="pdtCell"><h2>'.$result['designation'].'</h2>';
    echo $result['descriptif'].'</td>';
    echo '<td class="poidsCell">Poids : '.$result['poidsP'].'g</td>';
    echo '<td class="imgPdtCell"><img class="imgProduit" src="'.$result["photoP"].'"></td>';
    $sql = $pdo->prepare('SELECT ALLERGENE.denomination, EXISTER.presence, EXISTER.trace FROM ALLERGENE, EXISTER WHERE EXISTER.refP = "'.$codeCat[0].'00'.$i.'" AND ALLERGENE.id = EXISTER.id;');
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
    echo '<label for="qte'.$codeCat[0].'00'.$i.'">Quantité :<label>';
    echo '<input class="qteForm" type="number" step="1" id="qte'.$codeCat[0].'00'.$i.'" name="qte'.$codeCat[0].'00'.$i.'" value="0"></td>';
    echo "</tr>";
}
echo "</table>";
echo '<br><input class="panier" type="submit" value="🛒 Ajouter au panier">';
echo "</form>";

?>
