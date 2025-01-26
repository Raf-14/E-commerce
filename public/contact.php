<?php
// public/index.php
session_start();
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
            <div class="contact-form">
                    <h2>Contactez-nous</h2>
                    <form id="contact-form" method="POST" action="../functions/send_mail.php">
                        <?php if (isset($_GET['success'])): ?>
                            <p class="success-message">Votre message a été envoyé avec succès !</p>
                        <?php endif; ?>

                        <div class="container-field">
                            <label for="name">Nom :</label>
                            <input type="text" id="name" name="name" placeholder="Entrer votre Nom *" required>
                        </div>
                        
                        <div class="container-field">
                            <label for="email">Adresse Email :</label>
                            <input type="email" id="email" name="email" placeholder="Entrer votre E-mail*" required>
                        </div>
                        
                        <div class="container-field">
                            <label for="phone">Téléphone :</label>
                            <input type="tel" id="phone" name="phone" placeholder="Entrer votre téléphone *" required>
                        </div>

                        <div class="container-field">
                            <label for="subject">Sujet :</label>
                            <input type="text" id="subject" name="subject" placeholder="Entrer le sujet de votre message ..." required>
                        </div>
                        
                        <div class="container-field">
                            <label for="message">Message :</label>
                            <textarea id="message" name="message" rows="5" placeholder="Entrer votre  Message ..." required></textarea>
                        </div>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>

            </div>
        </section>

      </main>
    <!-- Footer -->
     <?php include '../includes/footer.php'?>
   

     <script src="./assets/script/app.js"></script>
    <script src="./assets/script/function.js"></script>
    <script src="./assets/script/script.js"></script>
</body>
</html>

    