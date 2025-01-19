<?php 
require_once "../config/database.php";
$bdd = bdd();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="./assets/style/style.css"> 
</head>
<body>
  
      <!-- Header import since include folder -->
       <?php include '../includes/header.php';?>

    <div class="cart"></div>
        <!-- Footer import since include folder -->
        <?php include '../includes/footer.php';?>

    <script src="./assets/script/app.js"></script>

    <script src="./assets/script/script.js"></script> <!-- link to your JavaScript file -->
</html>
</body>
</html>
