<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php
    // Paramètres de connexion à la base de données
    $serveur = "localhost:3306"; // ou l'adresse IP du serveur MySQL
    $utilisateur = "root"; // Remplacez par votre nom d'utilisateur MySQL
    $motDePasse = ""; // Remplacez par votre mot de passe MySQL
    $baseDeDonnees = "php_christophe"; // Remplacez par le nom de votre base de données

    // Connexion à la base de données
    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    // Vérification de la connexion
    if (!$connexion) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    // Vérification du formulaire soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérification des champs requis
        $errors = [];
        if (empty($_POST["inscription_pseudo"])) {
            $errors[] = "Le pseudo est requis.";
        } elseif (strlen($_POST["inscription_pseudo"]) < 2 || strlen($_POST["inscription_pseudo"]) > 255) {
            $errors[] = "Le pseudo doit contenir entre 2 et 255 caractères.";
        }

        if (empty($_POST["inscription_email"])) {
            $errors[] = "L'email est requis.";
        }

        if (empty($_POST["inscription_motDePasse"]) || empty($_POST["inscription_motDePasse_confirmation"])) {
            $errors[] = "Les deux champs de mot de passe sont requis.";
        } elseif ($_POST["inscription_motDePasse"] !== $_POST["inscription_motDePasse_confirmation"]) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($_POST["inscription_motDePasse"]) < 8 || strlen($_POST["inscription_motDePasse"]) > 72) {
            $errors[] = "Le mot de passe doit contenir entre 8 et 72 caractères.";
        }

        // Si aucune erreur, traitement des données
        if (empty($errors)) {
            // Traitement des données d'inscription, par exemple, enregistrement dans une base de données
            // Ici, vous pouvez utiliser $connexion pour exécuter vos requêtes SQL
            // Redirection vers une page de confirmation ou de connexion
            header("Location: connection.php");
            exit();
        } else {
            // Affichage des erreurs
            echo "<div>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($connexion);
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="inscription_pseudo">Pseudo :</label><br>
            <input type="text" id="inscription_pseudo" name="inscription_pseudo" value="<?php echo isset($_POST['inscription_pseudo']) ? $_POST['inscription_pseudo'] : ''; ?>" required minlength="2" maxlength="255"><br>
        </div>
        <div>
            <label for="inscription_email">Email :</label><br>
            <input type="email" id="inscription_email" name="inscription_email" value="<?php echo isset($_POST['inscription_email']) ? $_POST['inscription_email'] : ''; ?>" required><br>
        </div>
        <div>
            <label for="inscription_motDePasse">Mot de passe :</label><br>
            <input type="password" id="inscription_motDePasse" name="inscription_motDePasse" required minlength="8" maxlength="72"><br>
        </div>
        <div>
            <label for="inscription_motDePasse_confirmation">Confirmation du mot de passe :</label><br>
            <input type="password" id="inscription_motDePasse_confirmation" name="inscription_motDePasse_confirmation" required minlength="8" maxlength="72"><br>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html> -->
