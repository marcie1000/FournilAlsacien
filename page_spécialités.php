<!DOCTYPE html>
<html>
    <body>
        <h1>Les Spécialitées du Fournil Alsacien</h1>
        <?php
        include "dbConnect.php";
        $pdo = dbconnect();
        $codeCat = "SPECI";
        include "affiche_produit.php";
        ?>
    </body>
</html>
