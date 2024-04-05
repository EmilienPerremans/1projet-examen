<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php
    // Fonction pour gérer les exceptions PDO
    function gerer_exceptions(PDOException $e) {
        echo "Erreur d'exécution de requête : " . $e->getMessage() . PHP_EOL;
    }

    // Fonction pour établir la connexion à la base de données
    function connexion_bdd() {
        $serveur = "localhost"; // Adresse du serveur MySQL
        $utilisateur = "root"; // Nom d'utilisateur MySQL
        $motDePasse = ""; // Mot de passe MySQL
        $baseDeDonnees = "php_christophe"; // Nom de la base de données

        // Créer une nouvelle connexion PDO
        $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);

        // Définir le mode d'erreur sur "exception"
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les valeurs du formulaire
        $pseudo = htmlspecialchars($_POST['inscription_pseudo']);
        $email = htmlspecialchars($_POST['inscription_email']);
        $motDePasse = $_POST['inscription_motDePasse'];
        $motDePasseConfirmation = $_POST['inscription_motDePasse_confirmation'];

        // Vérifier si les mots de passe correspondent
        if ($motDePasse !== $motDePasseConfirmation) {
            echo "Les mots de passe ne correspondent pas.";
        } else {
            try {
                // Établir la connexion à la base de données
                $pdo = connexion_bdd();

                // Préparer la requête d'insertion avec des paramètres sécurisés
                $requete = $pdo->prepare("INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse, uti_code_activation) VALUES (?, ?, ?, ?)");

                // Générer un code d'activation aléatoire
                $code_activation = rand(10000, 99999);

                // Exécuter la requête en passant les valeurs en paramètres
                $requete->execute([$pseudo, $email, password_hash($motDePasse, PASSWORD_DEFAULT), $code_activation]);

                echo "Inscription réussie !";
            } catch (PDOException $e) {
                gerer_exceptions($e);
            }
        }
    }
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
</html>
