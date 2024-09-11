<!DOCTYPE html>
<?php
echo '
<html lang="fr">
    <header>
        <form class="formHeader" action="index.php" method="post">';
// Permet de transmettre de page en page les informations de l'identifiant et du mot de passe
include("transmettre_info.php");
echo '
            <img class="logo" src="images/logo_le_fournil.jpg">
            <input type="submit" class="headerElem hBtn" name="page" value="Le fournil alsacien">
            <div class="headerElem">Nos produits : </div>
            <input type="submit" class="headerElem hBtn" name="page" value="Pains">
            <input type="submit" class="headerElem hBtn" name="page" value="Viennoiseries">
            <input type="submit" class="headerElem hBtn" name="page" value="Spécialités">
            <input type="submit" class="headerElem hBtn" name="page" value="Commandes">
';

if($idU == 'visiteur')
{
    echo '
            <input type="submit" class="headerElem hBtn" name="page" value="Connexion">
            </form>
        </header>
    </html>
    ';
}
else
{
    echo '
    <div class="headerElem username">👤 '.$idU.'</br>
    </form>
    <input type="submit" class="headerElem hBtn" name="page" value="Déconnexion"></div>
    </header>
    </html>';
}
?>
