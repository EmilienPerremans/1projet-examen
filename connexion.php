<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<?php  // HEADER

require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php");
?>

<h1>Connexion</h1>

<?php
session_start();

// Afficher un message d'erreur s'il y en a un
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']);
}

// Fonction pour gérer les exceptions PDO
function gerer_exceptions(PDOException $e) {
    echo "Erreur d'exécution de requête : " . $e->getMessage() . PHP_EOL;
}

// Fonction pour établir la connexion à la base de données
function connexion_bdd() {
    $serveur = "sql200.infinityfree.com"; 
    $utilisateur = "if0_36726361"; 
    $motDePasse = "F1qv235NwO"; 
    $baseDeDonnees = "if0_36726361_examen_php"; 

    // Créer une nouvelle connexion PDO
    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);

    // Définir le mode d'erreur sur "exception"
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $pseudo = htmlspecialchars($_POST['connexion_pseudo']);
    $motDePasse = $_POST['connexion_motDePasse'];

    try {
        // Établir la connexion à la base de données
        $pdo = connexion_bdd();

        // Requête pour vérifier les informations de connexion
        $requete = $pdo->prepare("SELECT * FROM t_utilisateur_uti WHERE uti_pseudo = ?");
        $requete->execute([$pseudo]);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if ($utilisateur && password_verify($motDePasse, $utilisateur['uti_motdepasse'])) {
            // Stocker les informations de l'utilisateur dans la session
            setcookie("pseudo", $pseudo, time() + 3600, "/");

            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['uti_id'] = $utilisateur['uti_id'];
            $_SESSION['email'] = $utilisateur['uti_email'];

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
