<?php
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil Fournil alsacien</title>
        <?php include("fonts.php");?>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php

        //Récupère les identifiants après la page page_connexion.php
        //(nouvelle tentative de connexion)
        include("recupere_identifiants.php");
        $identifiants = recupereIdentifiants();

        //variables temporaires
        $idU = null;
        $mdpU = null;

        //récupère les identifiants sur la page précédente si une connexion est déjà effectuée
        //sinon, utilise les identifiants visiteur visiteur
        if(isset($_POST['idU']))
            $idU = $_POST['idU'];
        else
            $idU = 'visiteur';
        if(isset($_POST['mdpU']))
            $mdpU = $_POST['mdpU'];
        else
            $mdpU = 'visiteur';

        //si un des champs identifiant/mot de passe n'est pas rempli, utilise les valeurs précédentes
        //ou les valeurs "visiteur" par défaut
        if($identifiants == null) {
            $identifiants['user'] = $idU;
            $identifiants['password'] = $mdpU;
        }

        //teste les identifiants. Si mauvais, utilise "visiteur"
        include("dbConnect.php");
        $pdo = dbConnect($identifiants['user'], $identifiants['password']);
        if($pdo == null){
            $pdo = dbConnect('visiteur', 'visiteur');
            $idU = 'visiteur';
            $mdpU = 'visiteur';
            include("header.php");
            echo "<section>";
            echo '<div class="errorMsg"><p>Erreur : identifiant ou mot de passe incorrect.</p></div>';
            include("page_connexion.php");
            echo "</section>";
            include("footer.php");
            die();
        }

        include("header.php");
        echo "<section>";
        /* echo $identifiants['user'].' '.$identifiants['password']; */

        //récupère le nom de la page que l'on souhaite obtenir
        $page = null;
        if(isset($_POST["page"])) {
            $page = strtolower($_POST["page"]);
            // enlève les espaces
            for($i = 0; $i<strlen($page); $i++) {
                if($page[$i] == ' ')
                    $page[$i] = '_';
            }
        }

        if(isset($_POST['info']) and $_POST['info'] == 'commande')
            $page = 'commandes';
        $validerPanier = false;
        if(isset($_POST['validerPanier'])){
            $validerPanier = true;
            $page = 'commandes';
        }

        // Choisit la bonne page
        switch($page){
            case null:
            case "le_fournil_alsacien":
                include("accueil.php");
                break;
            case "commandes":
                include('page_commandes.php');
                affPageCommandes($pdo, $idU, $mdpU, $validerPanier);
                break;
            case "déconnexion":
                include("déconnexion.php");
                break;
            case "créer_un_compte":
                include("créer_un_compte.php");
                creerUser($pdo);
                break;
            default:
                if(file_exists('page_'.$page.'.php'))
                    include('page_'.$page.'.php');
                else
                    echo "<h1>Erreur</h1><p>La page demandée n'existe pas</p>";
                break;
        }

        echo "</section>";
        include("footer.php");
        ?>
    </body>
</html>
