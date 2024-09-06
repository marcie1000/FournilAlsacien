<?php
echo '
<html lang="fr">
    <footer>
        <form action="index.php" method="post" class="formFooter">';
// Permet de transmettre de page en page les informations de l'identifiant et du mot de passe
include("transmettre_info.php");
echo '
<input type="submit" class="footerElem fBtn" name="page" value="Mentions légales">
<input type="submit" class="footerElem fBtn" name="page" value="Nous contacter">
</form>
</footer>
</html>';
?>
