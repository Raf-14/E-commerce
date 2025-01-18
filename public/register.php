<?php 
 require_once "../config/database.php";
 $bdd = bdd();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" type="text/css"  href="./assets/style/style.css"> <!-- link to your CSS file -->
</head>
<body>
    <!-- header include since includes header.php -->
     <?php include '../includes/header.php';?>

     <?php
// Traitement du formulaire si soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $role = 'customer'; // Par défaut, le rôle est 'customer'
    $secret_code = $_POST["secret_code"] ?? ''; // Code secret pour admin (s'il est soumis)

    // Vérification si les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "<div class='error'>Les mots de passe ne correspondent pas.</div>";
    } else {
        // Validation du code secret pour attribuer le rôle 'admin'
        if ($secret_code === "admin_code") {
            $role = 'admin'; // Si le code secret est correct, l'utilisateur devient admin
        }

        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $bdd = bdd();
            // Vérification de l'unicité de l'adresse email
            $stmt = $bdd->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "<div class='error'>Cette adresse email est déjà utilisée.</div>";
                $stmt->closeCursor();
                exit();
            }
            // Préparer la requête d'insertion
            $stmt = $bdd->prepare("INSERT INTO users (username, email, password, last_name, phone, address, role) 
                                    VALUES (:username, :email, :password, :last_name, :phone, :address, :role)");

            // Lier les paramètres
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':role', $role);

            // Exécuter la requête
            $stmt->execute();

            echo "<div class='success'>Compte créé avec succès !</div>";
        } catch (PDOException $e) {
            echo "<div class='error'>Erreur : " . $e->getMessage() . "</div>";
        }

        // Fermer la connexion
        $conn = null;
    }
}
?>
<main>
    <section>
        <div id="success_message" class="success"></div>
        <div id="error_message" class="error"></div>

        <div class="form-container">
            <h2>Créer un compte</h2>
            <form action="" method="post">
                <!-- Nom d'utilisateur -->
                <div class="form-groupe">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <!-- Email -->
                <div class="form-groupe">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <!-- Mot de passe -->
                <div class="form-groupe">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Confirmer le mot de passe -->
                <div class="form-groupe">
                    <label for="confirm_password">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <!-- Nom de famille -->
                <div class="form-groupe">
                    <label for="last_name">Nom de famille :</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>

                <!-- Téléphone -->
                <div class="form-groupe">
                    <label for="phone">Téléphone :</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <!-- Adresse -->
                <div class="form-groupe">
                    <label for="address">Adresse :</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <!-- Code secret (si admin) -->
                <div class="form-groupe">
                    <label for="secret_code">Code secret (admin uniquement) :</label>
                    <input type="password" id="secret_code" name="secret_code">
                    <small>Si vous êtes administrateur, entrez le code secret ici.</small>
                </div>

                <!-- Bouton d'inscription -->
                <div class="form-groupe">
                    <button type="submit">Créer un compte</button>
                </div>

                <p><a href="login.php">Vous avez déjà un compte ? Connectez-vous ici.</a></p>
            </form>
        </div>
    </section>
</main>

   
    <!-- footer include since includes footer.php -->
     <?php include '../includes/footer.php';?>

     <script src="./assets/script/app.js"></script>

</body>
</html>