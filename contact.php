




<?php
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

    // Affichage des erreurs ou envoi du formulaire
    if (!empty($erreurs)) {
        // Affichage des erreurs
        foreach ($erreurs as $erreur) {
            echo "<p>$erreur</p>";
        }
    } else {
        // Envoi du formulaire
        $destinataire = "destinataire@example.com";
        $message = "Message: " . $message;
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($destinataire, "Nouveau message de contact", $message, $headers)) {
            echo "E-mail envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'e-mail.";
        }
    }
}
?>

<?php // Ajout du header
$titrePage = "Contact";
require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php") ;
?> 

<link rel="stylesheet" href="css/contacte.css"> //voir si c'est good 
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

<!-- <?php // Ajout du footer
require_once (__DIR__ . DIRECTORY_SEPARATOR . "footer.php") 
?>  -->