<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if(empty($_POST['prenom'])){
        echo "Le champ prenmo est requi ";
        exit;
    }
}
$titrePage ="Contact";
$metaDescription ="Description page contact"; 
require_once "header.php";
?>


<h1>Contact</h1>

<form method="post" action="" >
    <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" minlength="2" maxlength="255"  required>
    <br><br>
    <label for="prenom">Prénom :<label>
        <input type="text" id="prenom" name="prenom" minlength="2" maxlength="255">
    <br><br>
    <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    <br><br>
    <label for="message">Message</label>
        <input type="text" id="message" name="message" minlength="10" maxlength="3000" required>
    <br><br>
    <button type="submit">Envoyer</button>
</form> 


<?php  // FOOTER 
require_once "footer.php"
?>
