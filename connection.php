<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

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
                echo "Connexion réussie pour l'utilisateur : " . $pseudo;
                // Ici, vous pouvez rediriger l'utilisateur vers une page sécurisée
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
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
