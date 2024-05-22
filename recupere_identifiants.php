<?php
function recupereIdentifiants() {
    $cnxIdentifiant = null;
    $cnxPwd = null;
    if(!isset($_POST['cnxIdentifiant']) or !isset($_POST['cnxPwd'])) {
        return null;
    }
    $cnxIdentifiant = $_POST['cnxIdentifiant'];
    $cnxPwd = $_POST['cnxPwd'];
    $tab = array(
        "user" => $cnxIdentifiant,
        "password" => $cnxPwd
    );
    return($tab);
}
?>
