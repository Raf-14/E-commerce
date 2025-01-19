<?php
// public/index.php

require_once '../config/database.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Alimentaire</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- En-tête -->
    <?php include '../includes/header.php' ?>

    <!-- Main conyent -->
      <main>
        <section>
            <!-- contact form -->
             <div class="wrapper contact">
                 <h2>Contactez-nous</h2>
                 <form action="#" method="post">
                     <div class="form-contact">
                         <label for="name">Nom:</label>
                         <input type="text" id="name" name="name" required>
                     </div>
                     <div class="form-contact">
                         <label for="email">Email:</label>
                         <input type="email" id="email" name="email" required>
                     </div>
                     <div class="form-contact">
                         <label for="message">Message:</label>
                         <textarea id="message" name="message" rows="5" required></textarea>
                     </div>
                     <button type="submit">Envoyer</button>
                 </form>
             </div>
             </div>
        </section>

      </main>
   

    <!-- Footer -->
     <?php include '../includes/footer.php'?>
   

    <script type="module" src="./assets/script/app.js"></script>
</body>
</html>

    