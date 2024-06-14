<?php
session_start();

// Fermer la connexion PDO en la mettant à null
if (isset($pdo)) {
    $pdo = null;
}

// Supprimer toutes les variables de session
session_unset();
setcookie("pseudo", "", time() - 3600, "/");

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion avec un message approprié
$_SESSION['error_message'] = "Vous avez été déconnecté.";
header("Location: connexion.php");
exit();
?>
