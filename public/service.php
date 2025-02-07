<?php
require_once '../config/database.php';
$bdd = bdd();
session_start();
// if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
//     header("Location: index.php");  // Rediriger vers la page d'accueil si déjà connecté
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eService</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <!-- <link rel="stylesheet" type="text/css" href="./assets/style/style.css"> -->
    <style>
/* styles for service page */
h1, h2 {
    color: #333;
}

section {
    background-color: white;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"] {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #333;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
}

button:disabled, button.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

    </style>
</head>
<body>
   
    <!--Header import since includes  -->
    <?php include '../includes/header.php';?>

    <section id="support-client">
        <h2>Support Client</h2>
        <p>Besoin d'aide ? Contactez-nous par chat en ligne, email ou téléphone.</p>
        <button>Chat en Ligne</button>
        <p>Email: support@ecommerce.com</p>
        <p>Téléphone: +123 456 7890</p>
    </section>

    <section id="faq">
        <h2>FAQ</h2>
        <ul>
            <li><a href="#question1">Comment suivre ma commande ?</a></li>
            <li><a href="#question2">Comment retourner un produit ?</a></li>
            <li><a href="#question3">Quels sont les modes de paiement acceptés ?</a></li>
        </ul>
    </section>

    <section id="suivi-commandes">
        <h2>Suivi des Commandes</h2>
        <form>
            <label for="order-number">Numéro de commande :</label>
            <input type="text" id="order-number" name="order-number" required>
            <button type="submit">Suivre</button>
        </form>
    </section>

    <section id="retours-remboursements">
        <h2>Retours et Remboursements</h2>
        <p>Initiate a return or request a refund.</p>
        <form>
            <label for="return-order-number">Numéro de commande :</label>
            <input type="text" id="return-order-number" name="return-order-number" required>
            <button type="submit">Retourner</button>
        </form>
    </section>

    <!-- footer import since includes  -->
    <?php include "../includes/footer.php"?>

    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>
</html>

    
   