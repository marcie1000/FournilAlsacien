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
    include("header.php");

    echo "<section>";

    $page = null;
    if(isset($_POST["page"])) {
        $page = strtolower($_POST["page"]);
        // enlève les espaces
        for($i = 0; $i<strlen($page); $i++) {
            if($page[$i] == ' ')
                $page[$i] = '_';
        }
    }

    if($page == null || $page == "le_fournil_alsacien")
        include("accueil.php");
    else if(file_exists('page_'.$page.'.php'))
        include('page_'.$page.'.php');
    else{
        echo "<h1>Erreur</h1><p>La page demandée n'existe pas</p>";
    }

    echo "</section>";
    include("footer.php");
    ?>
</body>
</html>
