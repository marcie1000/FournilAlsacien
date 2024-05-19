<!DOCTYPE html>
<html>
    <body>
        <h1>Les Pains du Fournil Alsacien</h1>
        <?php
        include "dbConnect.php";
        $pdo = dbconnect();
        $codeCat = "PAINS";
        include "affiche_produit.php";

        ?>
    </body>
</html>
