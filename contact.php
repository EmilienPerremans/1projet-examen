<?php
// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'examen_php';
$username = 'root';
$password = '';


  // HEADER

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialisation du tableau pour les messages d'erreurs
    $erreurs = [];

    // Récupération des données du formulaire et nettoyage
    $nom = htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $email = htmlentities($_POST["email"]);
    $message = htmlentities($_POST["message"]);

    // Validation du nom
    if (!empty($nom)) {
        if (strlen($nom) < 2 || strlen($nom) > 255) {
            $erreurs[] = "Le nom doit contenir entre 2 et 255 caractères";
        }
    } else {
        $erreurs[] = "Veuillez saisir votre nom";
    }

    // Validation du prénom
    if (!empty($prenom)) {
        if (strlen($prenom) < 2 || strlen($prenom) > 255) {
            $erreurs[] = "Le prénom doit contenir entre 2 et 255 caractères";
        }
    } else {
        $erreurs[] = "Veuillez saisir votre prénom";
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse email invalide";
    }

    // Validation du message
    if (!empty($message)) {
        if (strlen($message) < 10 || strlen($message) > 3000) {
            $erreurs[] = "Le message doit contenir entre 10 et 3000 caractères";
        }
    } else {
        $erreurs[] = "Veuillez saisir un message";
    }

    // Vérification de l'utilisateur dans la base de données
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT uti_id FROM t_utilisateur_uti WHERE uti_email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // L'utilisateur existe, insertion du message dans la base de données
                $stmt = $pdo->prepare("INSERT INTO t_message_msg (msg_contenu, msg_date_envoi, uti_id) VALUES (:contenu, NOW(), :uti_id)");
                $stmt->bindParam(':contenu', $message);
                $stmt->bindParam(':uti_id', $user['uti_id']);

                if ($stmt->execute()) {
                    echo "Message envoyé avec succès et enregistré dans la base de données.";
                } else {
                    $erreurs[] = "Une erreur s'est produite lors de l'enregistrement du message dans la base de données.";
                }
            } else {
                $erreurs[] = "Utilisateur non trouvé. Veuillez vérifier votre adresse email.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de base de données : " . $e->getMessage();
        }
    }

    // Affichage des erreurs
    if (!empty($erreurs)) {
        foreach ($erreurs as $erreur) {
            echo "<p>$erreur</p>";
        }
    }
}
?>

<?php
// Ajout du header
$titrePage = "Contact";
require_once(__DIR__ . DIRECTORY_SEPARATOR . "header.php");
?>

<link rel="stylesheet" href="css/contacte.css">
<body>
    <h1>Contact</h1>
    <form method="post" action="">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" minlength="2" maxlength="255" required>
        <br><br>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" minlength="2" maxlength="255" required>
        <br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="5" cols="40" minlength="10" maxlength="3000" required></textarea>
        <br><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>

<!-- <?php
// Ajout du footer
require_once(__DIR__ . DIRECTORY_SEPARATOR . "footer.php");
?> -->
