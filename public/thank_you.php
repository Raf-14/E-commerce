<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre commande</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" type="text/css"  href="./assets/style/style.css">
</head>
<body>
    <div class="thanks-container-page">
        <h1>Merci pour votre commande !</h1>
        <p>Votre commande a été enregistrée avec succès.</p>
        <p>Nous vous remercions de votre confiance en nous. Vous pouvez maintenant consulter votre panier ou vous rendre sur votre profil pour suivre l'état de votre commande.</p>
        <p>Veuillez noter que vous pouvez également consulter les dernières commandes passées en cliquant sur le lien "Mes commandes" dans votre profil.</p>
        <a href="profile.php">Voir mon profil</a>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
