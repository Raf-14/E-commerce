<?php 
 require_once "../config/database.php";
 $bdd = bdd();

//  session_start();
 if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
     header("Location: index.php");  // Rediriger vers la page d'accueil si déjà connecté
     exit;
 }
 
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
        
     <!-- vérification du tableau erreur si , ils ne sont pas vide lors d'insertion de donnée -->
        <?php
           // Vérifier s'il y a des erreurs dans la session
            if (!empty($_SESSION['errors'])) {
                echo '<div class="errors">';
                foreach ($_SESSION['errors'] as $error) {
                    echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';

                // Une fois les erreurs affichées, on les supprime pour éviter qu'elles restent après le rechargement de la page
                unset($_SESSION['errors']);
            } 
        ?>
        
        <!-- formulaire de création de compte -->
        <div class="form-container">
        <h2>Créer un compte</h2>
        <form action="" method="post" id="register-form">
            <!-- Nom d'utilisateur -->
            <div class="form-groupe">
                <label for="username">Nom :</label>
                <input type="text" id="username" name="username" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Nom de famille -->
            <div class="form-groupe">
                <label for="last_name">Prénom :</label>
                <input type="text" id="last_name" name="last_name" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Email -->
            <div class="form-groupe">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Mot de passe -->
            <div class="form-groupe">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Confirmer le mot de passe -->
            <div class="form-groupe">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Téléphone -->
            <div class="form-groupe">
                <label for="phone">Téléphone :</label>
                <input type="tel" id="phone" name="phone" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Adresse -->
            <div class="form-groupe">
                <label for="address">Adresse :</label>
                <input type="text" id="address" name="address" required>
                <span class="success"></span>
                <span class="error"></span>
            </div>

            <!-- Code secret (si admin) -->
            <div class="form-groupe1">
                <label for="secret_code">Code secret (admin uniquement) :</label>
                <input type="password" id="secret_code" name="secret_code">
                <small>Si vous êtes administrateur, entrez le code secret ici.</small>
            </div>

            <!-- Bouton d'inscription -->
            <div class="form-groupe">
                <button type="submit">Créer un compte</button>
            </div>
            
            <!-- Affichage du spinner de chargement -->
            <div id="spinner" class="lds-spinner" style="display:none;">
                <div></div><div></div><div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div><div></div><div></div>
            </div>


            <p><a href="login.php">Vous avez déjà un compte ? Connectez-vous ici.</a></p>
        </form>
    </section>
</div>
</main>
    <!-- Footer -->
     <?php include '../includes/footer.php';?>
     <script src="./assets/script/app.js"></script> <!-- link to app.js file -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- link to jQuery library -->
     <script>
     function displayErrors(errors) {
    errors.forEach(error => {
        let errorMessage = $('<p>').css('color', 'red').text(error);
        $('.form-container').append(errorMessage);
    });
}

function showSpinner() {
    $('#spinner').show();
}

function hideSpinner() {
    $('#spinner').hide();
}

// Validation du formulaire
$('#register-form').on('submit', function(e) {
    e.preventDefault();
    $('#spinner').show();
    //un timeoute de 3s pour afficher le spinner
    setTimeout(function() {
    let username = $('#username').val();
    let last_name = $('#last_name').val();
    let email = $('#email').val();
    let password = $('#password').val();
    let confirm_password = $('#confirm_password').val();
    let phone = $('#phone').val();
    let address = $('#address').val();
    let secret_code = $('#secret_code').val();
    let errors = [];

    // Vérification des champs obligatoires
    if (username === '') {
        errors.push('Le nom d\'utilisateur est obligatoire.');
    }
    if (last_name === '') {
        errors.push('Le prénom est obligatoire.');
    }
    if (email === '') {
        errors.push('L\'adresse email est obligatoire.');
    }
    if (password === '') {
        errors.push('Le mot de passe est obligatoire.');
    }
    if (confirm_password === '') {
        errors.push('Confirmer le mot de passe est obligatoire.');
    }
    if (phone === '') {
        errors.push('Le téléphone est obligatoire.');
    }
    if (address === '') {
        errors.push('L\'adresse est obligatoire.');
    }

    // Vérification de la validité de l'email
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push('L\'adresse email n\'est pas valide.');
    }

    // Vérification des mots de passe identiques
    if (password !== confirm_password) {
        errors.push('Les mots de passe ne sont pas identiques.');
    }

    // Si il y a des erreurs, on les affiche
    if (errors.length > 0) {
        $('#spinner').hide();
        displayErrors(errors);
        return;
    }

    // Si aucune erreur, on envoie les données vers le serveur
    $.ajax({
        url: 'http://localhost/E-commerce/functions/functions.php',
        method: 'POST',
        data: {
            username: username,
            last_name: last_name,
            email: email,
            password: password,
            phone: phone,
            address: address,
            secret_code: secret_code
        },
        success: function(data) {
            $('#spinner').hide();
            // Si la réponse est positive, on affiche un message de succès et on efface les champs
            if (data.success) {
                $('.form-container').html('<p style="color: green;">Compte créé avec succès!</p>');
                $('.form-groupe input').val('');
            } else {
                let errorMessage = $('<p>').css('color', 'red').text(data.error);
                $('.form-container').append(errorMessage);
            }
        },
        error: function() {
            $('#spinner').hide();
            // Si une erreur est survenue, on affiche un message d'erreur
            let errorMessage = $('<p>').css('color', 'red').text('Erreur lors de la création du compte. Veuillez réessayer plus tard.');
            $('.form-container').append(errorMessage);
        }
    });
    }, 3000); // timeout de 3s pour afficher le spinner avant la validation du formulaire
});

     </script>

</body>
</html>