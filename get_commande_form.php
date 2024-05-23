<?php

$panier = null;

//réupère la liste des produits de la boulangerie
$sql = $pdo->prepare('SELECT PRODUIT.refP FROM PRODUIT;');
$sql->execute();
// refP => qte
while($row = $sql->fetch()){
    $panier[$row['refP']] = -1;
    if(isset($_POST['qte'.$row['refP']]))
        $panier[$row['refP']] = $_POST['qte'.$row['refP']];
}

/* echo var_dump($panier); */


?>
