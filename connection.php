<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<?php
require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php");
session_start();  // Démarrer la session

function gerer_exceptions(PDOException $e) {
    echo "Erreur d'exécution de requête : " . $e->getMessage() . PHP_EOL;
}

function connexion_bdd() {
    $serveur = "localhost"; 
    $utilisateur = "root"; 
    $motDePasse = ""; 
    $baseDeDonnees = "examen_php"; 

    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = htmlspecialchars($_POST['connexion_pseudo']);
    $motDePasse = $_POST['connexion_motDePasse'];

    try {
        $pdo = connexion_bdd();
        $requete = $pdo->prepare("SELECT * FROM t_utilisateur_uti WHERE uti_pseudo = ?");
        $requete->execute([$pseudo]);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($motDePasse, $utilisateur['uti_motdepasse'])) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $utilisateur['uti_email'];
            $_SESSION['uti_id'] = $utilisateur['uti_id'];

            header("Location: visualisation.php");
            exit();
        } else {
            echo "Identifiants incorrects. Veuillez réessayer.";
        }
    } catch (PDOException $e) {
        gerer_exceptions($e);
    }
}
?>

<h1>Connexion</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <label for="connexion_pseudo">Pseudo :</label><br>
        <input type="text" id="connexion_pseudo" name="connexion_pseudo" required minlength="2" maxlength="255"><br>
    </div>
    <div>
        <label for="connexion_motDePasse">Mot de passe :</label><br>
        <input type="password" id="connexion_motDePasse" name="connexion_motDePasse" required minlength="8" maxlength="72"><br>
    </div>
    <a href="inscription.php">Pas encore inscrit ?</a>
    <div>
        <button type="submit">Se connecter</button>
    </div>
</form>
</body>
</html>
