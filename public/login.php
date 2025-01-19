<?php
require_once '../config/database.php';
$bdd = bdd()

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" type="text/css"  href="./assets/style/style.css"> <!-- link to your CSS file -->
    <style>
    /* Style pour le spinner */
    .lds-spinner {
        display: block;
        width: 80px;
        height: 80px;
        margin: 0 auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .lds-spinner div {
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #000;
        animation: lds-spinner 1.2s linear infinite;
    }

    .lds-spinner div:nth-child(1) {
        animation-delay: -1.1s;
    }

    .lds-spinner div:nth-child(2) {
        animation-delay: -1s;
    }

    .lds-spinner div:nth-child(3) {
        animation-delay: -0.9s;
    }

    .lds-spinner div:nth-child(4) {
        animation-delay: -0.8s;
    }

    .lds-spinner div:nth-child(5) {
        animation-delay: -0.7s;
    }

    .lds-spinner div:nth-child(6) {
        animation-delay: -0.6s;
    }

    .lds-spinner div:nth-child(7) {
        animation-delay: -0.5s;
    }

    .lds-spinner div:nth-child(8) {
        animation-delay: -0.4s;
    }

    @keyframes lds-spinner {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

</head>

<body>
    <!-- Header of page include since includes header.php -->
     <?php include '../includes/header.php';?>
     
   <main>
   <?php
// session_start();

// Traitement de la connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la base de données
    try {

        $bdd = bdd();

        // Récupérer les informations du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Vérifier si l'utilisateur existe
        $query = "SELECT id, email, password, role FROM users WHERE email = :email";
        $stmt = $bdd->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role']; // Stocke le rôle de l'utilisateur
            
            // Rediriger selon le rôle
            if ($user['role'] === 'admin') {
                // Rediriger l'administrateur vers la page d'administration
                header('Location: admin_dashboard.php');
                exit;
            } else {
                // Rediriger un utilisateur normal vers la page d'accueil
                header('Location: index.php');
                exit;
            }
        } else {
            // Afficher un message d'erreur si l'authentification échoue
            echo "<p class='error'>Identifiants invalides.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>

<main>
    <section>
        <!-- Formulaire de connexion -->
        <form action="login.php" method="post" class="log_in" onsubmit="showSpinner()">
            <h2>Connexion</h2>
            <div class="form-groupe">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-groupe">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Connexion</button>
            <!-- Lien vers la page d'inscription -->
            <p><a href="register.php">Pas encore de compte ? Inscrivez-vous ici.</a></p>

            <!-- Lien pour mot de passe oublié -->
            <p><a href="#" class="forgot">Mot de passe oublié ?</a></p>

            <!-- Affichage du spinner de chargement -->
            <div id="spinner" class="lds-spinner" style="display:none;"></div>
        </form>
    </section>
</main>

<script>
    // Fonction pour afficher le spinner pendant le traitement du formulaire
    function showSpinner() {
        document.getElementById("spinner").style.display = "block";
    }
</script>

   </main>

   

     
    <!-- Footer of page include since includes footer.php -->
     <?php include '../includes/footer.php';?>


     <script type="module" src="./assets/js/script.js"></script> <!-- link to your JavaScript file -->
</html>
</body>
</html>