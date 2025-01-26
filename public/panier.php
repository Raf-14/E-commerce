<?php 
if (session_status() == 'PHP_SESSION_NONE') {
    session_start();
}
require_once "../config/database.php";
require_once "../functions/functions.php";
// Connexion à la base de données
$bdd = bdd();

// Vérifier si un utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit;
}

// Récupérer l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Tu peux maintenant utiliser $userId pour récupérer les informations du panier ou autre chose
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
</head>
<body>
  
      <!-- Header import since include folder -->
    <?php include '../includes/header.php';?>
     
    <div class="cart"></div>
    <!-- Footer import since include folder -->
    <?php include '../includes/footer.php';?>


    
    <script src="./assets/script/app.js"></script>
    <script src="./assets/script/function.js"></script>
    <script src="./assets/script/script.js"></script>
</html>
</body>
</html>
