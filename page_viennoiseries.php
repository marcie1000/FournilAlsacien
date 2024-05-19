<!DOCTYPE html>
<html>
    <body>
        <h1>Les Viennoiseries du Fournil Alsacien</h1>
        <?php
        include "dbConnect.php";
        $pdo = dbconnect();
        $codeCat = "VIENN";
        include "affiche_produit.php";
        ?>

    </body>
</html>
