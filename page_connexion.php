<?php
echo "<h1>Connexion</h1>";
echo '<form action="index.php" method="post">';
/* include("transmettre_info.php"); */
echo '<label for="idU">Identifiant :</label><br>';
echo '<input type="text" name="idU"><br><br>';
echo '<label for="mdpU">Mot de passe :</label><br>';
echo '<input type="password" name="mdpU"><br><br>';
echo '<input class="cnxBtn" type="submit" name="connexion" value="Se connecter">';
echo '</form>';
?>
