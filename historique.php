<?php 
// Valeur spÃ©cifique de la page
$titrePage = "Page d'historique utilisateur";
$metaDescription = "page utilisateur";
?>

<?php  // HEADER

require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php");
?>


<?php
function connexion_bdd() {
        $serveur = "localhost"; // Adresse du serveur MySQL
        $utilisateur = "root"; // Nom d'utilisateur MySQL
        $motDePasse = ""; // Mot de passe MySQL
        $baseDeDonnees = "examen_php"; // Nom de la base de données

        // Créer une nouvelle connexion PDO
        $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);

        // Définir le mode d'erreur sur "exception"
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

?>