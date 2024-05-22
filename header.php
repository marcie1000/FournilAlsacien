<!DOCTYPE html>
<?php
echo '
<html lang="fr">
    <header>
        <form class="formHeader" action="index.php" method="post">';
            include("transmettre_info.php");
            echo '
            <img class="logo" src="images/logo_le_fournil.jpg">
            <input type="submit" class="headerElem hBtn" name="page" value="Le fournil alsacien">
            <div class="headerElem">Nos produits : </div>
            <input type="submit" class="headerElem hBtn" name="page" value="Pains">
            <input type="submit" class="headerElem hBtn" name="page" value="Viennoiseries">
            <input type="submit" class="headerElem hBtn" name="page" value="Spécialités">
            <input type="submit" class="headerElem hBtn" name="page" value="Commandes">
            <input type="submit" class="headerElem hBtn" name="page" value="Connexion">
        </form>
    </header>
</html>
';
?>
