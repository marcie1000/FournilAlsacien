<!DOCTYPE html>
<html>
    <body>
            <h1>Les Pains du Fournil Alsacien</h1>
            <?php
            include "dbConnect.php";
            $pdo = dbconnect();

            // Notation objet PDO
            // PREPARE LA REQUETE
            $sql = $pdo->prepare('SELECT COUNT(*) AS nombre FROM PRODUIT WHERE PRODUIT.codeCat = "PAINS";');

            /* RELIER LES VALEURS A LA REQUETE
             * $sql->bindValue(':id', $id, PDO::PARAM_STR); // type ENTIER : PARAM_INT

             * $sql->bindValue(':pseudo', $pseudo, PDO::PARAM_STR); // type CHAINE DE CARACTEREE */


            $sql->execute(); // EXECUTE LA REQUETE
            $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
            $nb = $result['nombre'];
            echo "<table class='tabPdt'>";
            for ($i = 1; $i <= $nb; $i++) {
                    $sql = $pdo->prepare('SELECT prix, poidsP, designation, descriptif, photoP FROM PRODUIT WHERE PRODUIT.refP = "P00'.$i.'";');
                    $sql->execute();
                    $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
                    echo "<tr>";
                    echo '<td class="pdtCell"><h2>'.$result['designation'].'</h2>';
                    echo $result['descriptif'].'</td>';
                    echo '<td class="poidsCell">Poids : '.$result['poidsP'].'g</td>';
                    echo '<td class="imgPdtCell"><img class="imgProduit" src="'.$result["photoP"].'"></td>';
                    echo "</tr>";
            }
            echo "</table>";

            ?>
    </body>
</html>
