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
    if(isset($_POST["page"]))
        $page = $_POST["page"];

    switch($page)
    {
        default:
        include("accueil.php");
        echo "wooow";
        break;
    }
    echo "</section>";
    include("footer.php");
    ?>
</body>
</html>
