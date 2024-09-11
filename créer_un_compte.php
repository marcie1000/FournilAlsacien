<?php

function creerUser($pdo) {
    $idNew = $_POST['idNew'];
    $mdpNew = $_POST['mdpNew'];
    $mdpNewRepeat = $_POST['mdpNewRepeat'];
    $nomNew = $_POST['nomNew'];
    $prenomNew = $_POST['prenomNew'];
    $numVoieNew = $_POST['numVoieNew'];
    $nomVoieNew = $_POST['nomVoieNew'];
    $cpNew = $_POST['cpNew'];
    $villeNew = $_POST['villeNew'];
    $mailNew = $_POST['mailNew'];

    // vérifie que tous les champs sont remplis
    if(
        $idNew == "" or
        $mdpNew == "" or
        $mdpNewRepeat == "" or
        $nomNew == "" or
        $prenomNew == "" or
        $numVoieNew == "" or
        $nomVoieNew == "" or
        $cpNew == "" or
        $villeNew == "" or
        $mailNew == ""
    ) {
        echo '<div class="errorMsg"><p>Erreur : vous devez remplir tous les champs !</p></div>';
        include("page_connexion.php");
        return;
    }

    // vérifie que les deux mots de passe concordent
    if($mdpNew != $mdpNewRepeat) {
        echo '<div class="errorMsg"><p>Erreur : les deux mots de passe ne concordent pas !</p></div>';
        include("page_connexion.php");
        return;
    }

    // vérifie que l'utilisateur n'existe pas déjà
    try {
        $sql = $pdo->prepare("SELECT UTILISATEUR.idU FROM UTILISATEUR WHERE idU = '$idNew';");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }
    $row = $sql->fetchAll();
    $count = 0;
    foreach($row as $key=>$value) {
        $count++;
    }

    if($count >= 1) {
        echo '<div class="errorMsg"><p>Erreur : ce nom d\'utilisateur n\'est pas disponible !</p>';
        echo '<p>Merci d\'en choisir un autre.</p></div>';
        include("page_connexion.php");
        return;
    }

    // Crée l'utilisateur
    try {
        $sql = $pdo->prepare("INSERT INTO UTILISATEUR(idU, nomU, prenomU, numVoieU, nomVoieU, cpU, villeU, mailU)
                              VALUES ('".$idNew."', '".$nomNew."', '".$prenomNew."', '".$numVoieNew."', '".$nomVoieNew."',
                              '".$cpNew."', '".$villeNew."', '".$mailNew."');");
        $sql->execute();
        $sql = $pdo->prepare("DROP USER IF EXISTS '$idNew';");
        $sql->execute();
        $sql = $pdo->prepare("CREATE USER '$idNew'@'%' IDENTIFIED BY '$mdpNew';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT ON fournil_alsacien.CATEGORIE TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT ON fournil_alsacien.ALLERGENE TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT ON fournil_alsacien.PRODUIT TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT ON fournil_alsacien.EXISTER TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT ON fournil_alsacien.UTILISATEUR TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.COMMANDE TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT, INSERT, UPDATE, DELETE ON fournil_alsacien.QUANTIFIER TO '$idNew'@'%';");
        $sql->execute();
        $sql = $pdo->prepare("GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.UTILISATEUR TO '$idNew'@'%';");
        $sql->execute();
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }

    echo '<div class="infoMsg">Utilisateur créé avec succès ! Veuillez à présent vous connecter.</div>';
    include("page_connexion.php");
}



?>
