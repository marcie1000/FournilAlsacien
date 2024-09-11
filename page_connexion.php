<?php

// Connexion

echo '<div class="connexionColonnes">';
echo '<div class="ccElemMargin"><div class="ccElem">';
echo "<h1>Connexion</h1>";
echo '<form action="index.php" method="post">';
echo '<label for="idU">Identifiant :</label><br>';
echo '<input type="text" name="idU"><br><br>';
echo '<label for="mdpU">Mot de passe :</label><br>';
echo '<input type="password" name="mdpU"><br><br>';
echo '<input class="cnxBtn" type="submit" name="connexion" value="Se connecter">';
echo '</form>';
echo '</div></div>';

// Création d'un nouvel utilisateur

echo '<div class="ccElem">';
echo '<h1>Créer un compte</h1>';
echo '
<form action="index.php" method="post">
<div class="creerUserColonnes">
<div class="cuElem">
<label for="idNew">Identifiant <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="idNew"><br><br>
<label for="mdpNew">Mot de passe <span class="champObligatoire">*</span>:</label><br>
<input type="password" name="mdpNew"><br><br>
<label for="mdpNewRepeat">Répétez le mot de passe <span class="champObligatoire">*</span>:</label><br>
<input type="password" name="mdpNewRepeat"><br><br>
<label for="nomNew">Nom <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="nomNew"><br><br>
<label for="prenomNew">Prénom <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="prenomNew"><br><br>
</div><div class="cuElem">
Adresse : <br>
<label for="numVoieNew">Num. de voie <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="numVoieNew"><br><br>
<label for="nomVoieNew">Nom de la rue / voie <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="nomVoieNew"><br><br>
<label for="cpNew">Code postal <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="cpNew"><br><br>
<label for="villeNew">Ville <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="villeNew"><br><br>
<label for="mailNew">Adresse e-mail <span class="champObligatoire">*</span>:</label><br>
<input type="text" name="mailNew"><br><br>
</div></div>
<span class="champObligatoire">*</span> : Champ obligatoire<br><br>
<input class="cnxBtn" type="submit" name="page" value="Créer un compte">
';
echo '</div>';
echo '</div>';
echo '</form>';
?>
