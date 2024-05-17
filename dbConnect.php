<?php
//Annexes : quelques commandes PDO

// On capture les erreurs avec le boc try et le bloc catch permet d'afficher le message correspondant ? l'erreur si elle survient
/* try {
 *     $db = new PDO('mysql:host=localhost;dbname=fournil_alsacien;charset=utf8mb4','root',''); // Connexion BDD MySQL localhost ou mysql sous ubuntu
 *     return $db;
 * }
 * catch(Exception $e){
 *     die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
 * }
 *
 * // Notation objet PDO
 * // PREPARE LA REQUETE
 * $sql = $baseDeDonnees->prepare('SELECT COUNT(*) as nombre FROM test.demo WHERE nom=:id AND mdp=:pseudo;');
 *
 * // RELIER LES VALEURS A LA REQUETE
 * $sql->bindValue(':id', $id, PDO::PARAM_STR); // type ENTIER : PARAM_INT
 *
 * $sql->bindValue(':pseudo', $pseudo, PDO::PARAM_STR); // type CHAINE DE CARACTEREE
 *
 *
 * $sql->execute(); // EXECUTE LA REQUETE
 * $result = $sql->fetch(); // VA RECUPERER LE RESULTAT, fetchAll PEUT AUSSI ETRE UTILISE */
/* echo $result['nombre']; */


// On capture les erreurs avec le boc try et le bloc catch permet d'afficher le message correspondant ? l'erreur si elle survient
function dbconnect() {

    try {
        $host = "mysql";
        $dbname = "fournil_alsacien";
        $user = "root";
        $mdp = "root";
        $pdo = new PDO("mysql:host=$host; dbname=$dbname", "$user", "$mdp");

        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        return $pdo;
    }
    catch(Exception $e){
        die ('Erreur :'. $e->getMessage()); // Va mettre fin au programme et afficher l'erreur
    }

    echo "PDO!";

}
?>
