<?php
require_once "../config/database.php";
$bdd = bdd();

// Fonction de nettoyage des données utilisateur
function cleanUserData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function addUser() {
    global $bdd;
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = cleanUserData($_POST['username'] ?? '');
        $last_name = cleanUserData($_POST['last_name'] ?? '');
        $email = cleanUserData($_POST['email'] ?? '');
        $password = cleanUserData($_POST['password'] ?? '');
        $confirm_password = cleanUserData($_POST['confirm_password'] ?? '');
        $phone = cleanUserData($_POST['phone'] ?? '');
        $address = cleanUserData($_POST['address'] ?? '');
        $secret_code = cleanUserData($_POST['secret_code'] ?? '');
        $role = 'customer';

        if (empty($username)) $errors[] = "Le nom d'utilisateur est obligatoire.";
        if (empty($last_name)) $errors[] = "Le nom est obligatoire.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'email n'est pas valide.";
        if (strlen($password) < 10) $errors[] = "Le mot de passe doit contenir au moins 10 caractères.";
        if (empty($confirm_password)) $errors[] = "Le mot de passe de confirmation est obligatoire.";
        if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas.";
        if (empty($phone)) $errors[] = "Le numéro de téléphone est obligatoire.";
        if (empty($address)) $errors[] = "L'adresse est obligatoire.";

        if (!preg_match("/^[a-zA-Z0-9_-]+$/", $username)) $errors[] = "Le nom d'utilisateur ne peut contenir que des lettres, chiffres, underscores et tirets.";
        if (!preg_match("/^[a-zA-Z ]+$/", $last_name)) $errors[] = "Le nom ne peut contenir que des lettres et des espaces.";
        if (!preg_match("/^[a-zA-Z0-9, -]+$/", $address)) $errors[] = "L'adresse ne peut contenir que des lettres, chiffres, virgules, tirets et espaces.";

        $checkEmailStmt = $bdd->prepare("SELECT id FROM users WHERE email = :email");
        $checkEmailStmt->execute([':email' => $email]);
        if ($checkEmailStmt->rowCount() > 0) $errors[] = "L'email est déjà utilisé.";

        if ($secret_code === "admin_code") $role = 'admin';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: register.php");
            exit();
        }

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $bdd->prepare("INSERT INTO users (username, last_name, email, password, phone, address, role) VALUES (:username, :last_name, :email, :password, :phone, :address, :role)");
            $stmt->execute([
                ':username' => $username,
                ':last_name' => $last_name,
                ':email' => $email,
                ':password' => $hashed_password,
                ':phone' => $phone,
                ':address' => $address,
                ':role' => $role
            ]);
            echo json_encode(['message' => "Votre compte a été créé avec succès! Vous pouvez vous connecter maintenant."]);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $bdd->lastInsertId();
            $_SESSION['user_role'] = $role;
            
            if ($role === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: profile.php');
            }
            exit();
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la création de votre compte. Veuillez réessayer plus tard. Détails : " . $e->getMessage();
            echo json_encode($errors);
        }
    }
}

addUser();
?>
