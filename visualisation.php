<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation des Données</title>
</head>
<body>
<?php
require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php");
session_start();  // Démarrer la session

if (!isset($_SESSION['pseudo'])) {
    $_SESSION['error_message'] = "Vous devez d'abord vous connecter.";
    header("Location: connexion.php");
    exit();
}

function gerer_exceptions(PDOException $e) {
    echo "Erreur d'exécution de requête : " . $e->getMessage() . PHP_EOL;
}

function connexion_bdd() {
    $serveur = "sql200.infinityfree.com"; 
    $utilisateur = "if0_36726361"; 
    $motDePasse = "F1qv235NwO"; 
    $baseDeDonnees = "if0_36726361_examen_php"; 

    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

try {
    $pdo = connexion_bdd();
    $uti_id = $_SESSION['uti_id'];
    $pseudo = $_SESSION['pseudo'];
    $email = $_SESSION['email'];

    echo "<h1>Informations de l'utilisateur</h1>";
    echo "Pseudo : " . htmlspecialchars($pseudo) . "<br>";
    echo "Email : " . htmlspecialchars($email) . "<br>";

    function historique_info_utilisateur($pdo, $uti_id) {
        $requete = $pdo->prepare("SELECT * FROM t_message_msg WHERE uti_id = ?");
        $requete->execute([$uti_id]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    $messages = historique_info_utilisateur($pdo, $uti_id);

    if ($messages) {
        echo "<h2>Historique des messages :</h2>";
        echo "<ul>";
        foreach ($messages as $message) {
            echo "<li>" . htmlspecialchars($message['msg_contenu']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun message trouvé pour cet utilisateur.";
    }
} catch (PDOException $e) {
    gerer_exceptions($e);
}
?>

<!-- Formulaire de déconnexion -->
<form action="deconnexion.php" method="post">
    <button type="submit">Déconnexion</button>
</form>
</body>
</html>
