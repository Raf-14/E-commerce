<?php 
 require_once "../config/database.php";
 require_once "../functions/functions.php";
 $bdd = bdd();

//  session_start();
 if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
     header("Location: index.php");  // Rediriger vers la page d'accueil si déjà connecté
     exit;
 }

 addUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" type="text/css"  href="./assets/style/style.css"> <!-- link to CSS file -->
</head>
<body>
    <!-- header include since includes header.php -->
     <?php include '../includes/header.php';?>
<main>
    <section>
                <?php
                    // Vérifier s'il y a des erreurs dans la session
                    if (!empty($_SESSION['errors'])) {
                        echo '<div class="errors" style="color: red; padding: 10px; border: 1px solid red; background: #ffe6e6;">';
                        foreach ($_SESSION['errors'] as $error) {
                            echo '<p>' . htmlspecialchars($error) . '</p>';
                        }
                        echo '</div>';
                        unset($_SESSION['errors']); // Supprimer après affichage pour éviter la persistance
                    }
                ?>

                <!-- formulaire de création de compte -->
                <div class="form-container">
                    <h2>Créer un compte</h2>
                        <form action="" method="post" id="register-form">
                            <!-- Nom d'utilisateur -->
                            <div class="form-groupe">
                                <label for="username">Nom :</label>
                                <input type="text" id="username" name="username" placeholder="Entrer votre Nom *" required>
                                <span class="error" id="usernameError">Le nom est obligatoire.</span>
                            </div>

                            <!-- Prénom -->
                            <div class="form-groupe">
                                <label for="last_name">Prénom :</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Entrer votre Prénom *" required>
                                <span class="error" id="lastNameError">Le prénom est obligatoire.</span>
                            </div>

                            <!-- Email -->
                            <div class="form-groupe">
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" placeholder="Entrer votre Email *" required>
                                <span class="error" id="emailError">Veuillez entrer un email valide.</span>
                            </div>

                            <!-- Mot de passe -->
                            <div class="form-groupe">
                                <label for="password">Mot de passe :</label>
                                <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe *" required>
                                <span class="error" id="passwordError">Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.</span>
                            </div>

                            <!-- Confirmer le mot de passe -->
                            <div class="form-groupe">
                                <label for="confirm_password">Confirmer le mot de passe :</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmer votre mot de passe *" required>
                                <span class="error" id="confirmPasswordError">Les mots de passe ne correspondent pas.</span>
                            </div>

                            <!-- Téléphone -->
                            <div class="form-groupe">
                                <label for="phone">Téléphone :</label>
                                <input type="tel" id="phone" name="phone" placeholder="Entrer votre téléphone *" required>
                                <span class="error" id="phoneError">Le numéro de téléphone doit être au format international (ex: +33 612345678).</span>
                            </div>

                            <!-- Adresse -->
                            <div class="form-groupe">
                                <label for="address">Adresse :</label>
                                <input type="text" id="address" name="address" placeholder="Entrer votre Adresse *" required>
                                <span class="error" id="addressError">L'adresse est obligatoire.</span>
                            </div>

                            <!-- Code secret (admin) -->
                            <div class="form-groupe">
                                <label for="secret_code">Code secret (admin uniquement) :</label>
                                <input type="password" id="secret_code" name="secret_code">
                                <small>Si vous êtes administrateur, entrez le code secret ici.</small>
                            </div>

                            <!-- Bouton d'inscription -->
                            <div class="form-groupe">
                                <button type="submit" id="submitBtn" disabled>Créer un compte</button>
                            </div>
                        </form>                   
                </div>
    </section>
</main>
    <!-- Footer -->
     <?php include '../includes/footer.php';?>
     <script src="./assets/script/app.js"></script> <!-- link to app.js file -->
     <script src="./assets/script/function.js"></script>
     <script src="./assets/script/script.js"></script>
     <script>
        const username = document.getElementById("username");
        const lastName = document.getElementById("last_name");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");
        const phone = document.getElementById("phone");
        const submitBtn = document.getElementById("submitBtn");

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phonePattern = /^\+?\d{10,15}$/;
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        function validateForm() {
            let valid = true;

            // Nom d'utilisateur
            if (username.value.trim() === "") {
                document.getElementById("usernameError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("usernameError").style.display = "none";
            }

            // Prénom
            if (lastName.value.trim() === "") {
                document.getElementById("lastNameError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("lastNameError").style.display = "none";
            }

            // Email
            if (!emailPattern.test(email.value)) {
                document.getElementById("emailError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("emailError").style.display = "none";
            }

            // Mot de passe
            if (!passwordPattern.test(password.value)) {
                document.getElementById("passwordError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("passwordError").style.display = "none";
            }

            // Confirmation du mot de passe
            if (password.value !== confirmPassword.value) {
                document.getElementById("confirmPasswordError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("confirmPasswordError").style.display = "none";
            }

            // Téléphone
            if (!phonePattern.test(phone.value)) {
                document.getElementById("phoneError").style.display = "block";
                valid = false;
            } else {
                document.getElementById("phoneError").style.display = "none";
            }

            // Activer/Désactiver le bouton de soumission
            submitBtn.disabled = !valid;
        }

        // Écouteurs d'événements sur les champs du formulaire
        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("input", validateForm);
        });

        // Empêcher l'envoi du formulaire si les validations échouent
        document.getElementById("register-form").addEventListener("submit", function (event) {
            if (submitBtn.disabled) {
                event.preventDefault();
                alert("Veuillez remplir correctement le formulaire.");
            } else {
                alert("Inscription réussie !");
            }
        });
    </script>
   

</body>
</html>