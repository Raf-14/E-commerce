<?php
require_once '../config/database.php';
require_once '../functions/functions.php';
$bdd = bdd();
// session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");  // Rediriger vers la page d'accueil si déjà connecté
    exit;
}

loginUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" type="text/css"  href="./assets/style/style.css"> 
</head>

<body>
    <!-- Header of page include since includes header.php -->
     <?php include '../includes/header.php';?>
     
    <section>
        <!-- Formulaire de connexion -->
        <form action="" method="post" class="log_in" onsubmit="showSpinner()">
            <h2>Connexion</h2>
             <!-- vérification du tableau erreur si , ils ne sont pas vide lors d'insertion de donnée -->
                <div class="display-message"
                style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    gap: 10px;
                    color: red;
                    font-size: 0.9em;
                    margin: 0;
                    padding: 0;
                    list-style-type: none;
                    border: none;
                    background-color: transparent;
                    font-size: 1em;
                    color: red;
                    width: 100%;
                    max-width: 250px;
                    margin: 0 auto;
                    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                    padding: 10px;
                    border-radius: 5px;
                    transition: all 0.3s ease-in-out;
                "
                >
                <!-- Affichage des erreurs -->
                <?php
                if (isset($_SESSION['login_errors'])) {
                    foreach ($_SESSION['login_errors'] as $error) {
                        echo "<p style='color:red;'>$error</p>";
                    }
                    unset($_SESSION['login_errors']); // Supprimer après affichage
                }
                ?>
                </div>
            <div class="form-groupe">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>
            <div class="form-groupe">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <button type="submit">Connexion</button>
            <!-- Lien vers la page d'inscription -->
            <p><a href="register.php">Pas encore de compte ? Inscrivez-vous ici.</a></p>

            <!-- Lien pour mot de passe oublié -->
            <p><a href="" class="forgot">Mot de passe oublié ?</a></p>

            <!-- Affichage du spinner de chargement -->
            <div id="spinner" class="lds-spinner" style="display:none;">
                <div></div><div></div><div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div><div></div><div></div>
            </div>

        </form>
    </section>
</main>

<script src="./assets/script/app.js"></script>
<script>
    
    //Afficher et cacher le spiner
    function showSpinner() {
        document.getElementById("spinner").style.display = "block";
    }
    // Cacher le spinner
    function hideSpinner() {
        document.getElementById("spinner").style.display = "none";
    }
    // Fonction pour afficher le message d'erreur lors de la connexion
    function showErrorMessages(errors) {
        const errorMessages = document.getElementById('error-messages');
        errorMessages.innerHTML = "";
        errors.forEach(error => {
            const errorMessage = document.createElement('li');
            errorMessage.textContent = error;
            errorMessages.appendChild(errorMessage);
        });
    }
    // Fonction pour masquer tous les messages d'erreur
    function clearErrorMessages() {
        const errorMessages = document.getElementById('error-messages');
        errorMessages.innerHTML = "";
    }
    // Fonction pour masquer le message d'erreur lors de la connexion
    function hideError() {
        document.querySelector('.error').style.display = "none";
    }
    // Fonction pour afficher le message d'erreur lors de la connexion
    function showError() {
        document.querySelector('.error').style.display = "block";
    }
    // Fonction pour vérifier la validité de l'email lors du changement de texte
    function validateEmail() {
        const emailInput = document.getElementById('email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            emailInput.classList.add('error');
        } else {
            emailInput.classList.remove('error');
        }
        validateForm();
    }
    // Fonction pour vérifier la validité du mot de passe lors du changement de texte
    function validatePassword() {
        const passwordInput = document.getElementById('password');
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/;
        if (!passwordPattern.test(passwordInput.value)) {
            passwordInput.classList.add('error');
        } else {
            passwordInput.classList.remove('error');
        }
        validateForm();
    }
    // Fonction pour vérifier la validité du formulaire
    function validateForm() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.querySelector('.log_in button');
        submitBtn.disabled =!(emailInput.checkValidity() && passwordInput.checkValidity());
        hideError();
        hideSpinner();
        validateEmail();
        validatePassword();
        if (submitBtn.disabled) {
            submitBtn.classList.add('disabled');
        } else {
            submitBtn.classList.remove('disabled');
        }
        return!submitBtn.disabled;
         submitBtn.disabled = emailInput.value === '' || passwordInput.value === '';
         return!submitBtn.disabled;
    }
</script>
   
    <!-- Footer of page include since includes footer.php -->
     <?php include '../includes/footer.php';?>
     <script type="module" src="./assets/js/script.js"></script> <!-- link to your JavaScript file -->
</body>
</html>