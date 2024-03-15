<?php
 // Traitement du formulaire
if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Creation tableau pour les messages d'erreurs
    $erreurs = [];
    // Récuperation des données du formulaire
    $nom = htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $email = htmlentities($_POST["email"]);
    $message = htmlentities($_POST["message"]);

     // Nom
    if(isset($_POST["nom"]) && !empty($_POST["nom"]))
    {
        if(strlen($nom) < 10 || strlen($nom) > 255) {
            $erreurs = "Le nom ne peut contenir qu'entre 2 et 255 caractères";
       }
    }
    // Prenom
    if(isset($_POST["prenom"]) && !empty($_POST["prenom"]))
    {
        if(strlen($prenom) < 10 || strlen($prenom) > 255) {
            $erreurs = "Le nom ne peut contenir qu'entre 2 et 255 caractères";
       }
    }
    // Email
    if(isset($POST["email"]) && !empty($POST["email"])) {

    }
    // Message 
    if(isset($POST["message"]) && !empty($POST["message"])) {
        if(strlen($message) < 10 || strlen($message) > 3000) {
            $erreurs = "Le message ne peut contenir qu'entre 10 et 3000 caractères";
        }
    }
    // Condition pour afficher ou pas les erreurs
    if(!empty($erreurs)) {
    foreach ($erreurs as $erreur) {
        echo "<p>$erreur</p>";
    }
  } else {
    echo " Formulaire correct";
  }

}

// Valeur spécifique de la page
$titrePage ="Contact";
$metaDescription ="Description page contact"; 

?>


<?php // Ajout du header
require_once (__DIR__ . DIRECTORY_SEPARATOR . "header.php") 
?>


<h1>Contact</h1>

<form method="post" action="" >
    <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" minlength="2" maxlength="255"  required>
    <br><br>
    <label for="prenom">Prénom :<label>
        <input type="text" id="prenom" name="prenom" minlength="2" maxlength="255" required>
    <br><br>
    <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    <br><br>
    <label for="message">Message</label>
        <input type="text" id="message" name="message" minlength="10" maxlength="3000" required>
    <br><br>
    <button type="submit">Envoyer</button>
</form>

<?php
require_once (__DIR__ . DIRECTORY_SEPARATOR ."footer.php");
?>
