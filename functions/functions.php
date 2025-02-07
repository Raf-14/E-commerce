<?php 
session_start();
function add_to_db() {
    try {
        // Connexion à la base de données
        $bdd = bdd();

        // Chemin vers le fichier JSON
        $json_file = '../produits.json';

        // Vérification si le fichier JSON existe
        if (!file_exists($json_file)) {
            throw new Exception("Erreur : le fichier JSON est introuvable.");
        }

        // Lecture des données du fichier JSON
        $json_data = file_get_contents($json_file);

        // Décodage des données JSON en tableau associatif
        $products = json_decode($json_data, true);

        // Vérification du décodage JSON
        if (!$products) {
            throw new Exception("Erreur : impossible de décoder les données JSON.");
        }

        // Préparation de la requête SQL pour insérer les produits
        $stmt = $bdd->prepare("INSERT INTO products (name, description, price, stock, category_id, image_url) 
                                VALUES (:name, :description, :price, :stock, :category_id, :image_url)");

        // Parcours de chaque produit et insertion dans la base de données
        foreach ($products as $product) {
            try {
                // Exécution de l'insertion
                $stmt->execute([
                    ':name' => $product['name'],
                    ':description' => $product['description'],
                    ':price' => $product['price'],
                    ':stock' => $product['stock'],
                    ':category_id' => $product['category_id'],
                    ':image_url' => $product['image_url']
                ]);
                echo "Produit inséré : " . htmlspecialchars($product['name']) . "<br>";
            } catch (PDOException $e) {
                echo "Échec d'insertion du produit : " . htmlspecialchars($product['name']) . ". Erreur : " . $e->getMessage() . "<br>";
            }
        }
        // Message de succès
        echo "Tous les produits ont été traités avec succès.";
    } catch (Exception $e) {
        echo "Une erreur est survenue : " . $e->getMessage();
    }
}


// Fonction pour récupèrer tous les produits de la table

function getAllProducts(){
    global $bdd;
    $sql = "SELECT * FROM `products`";
    $stmt = $bdd->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Fonction pour récupèrer un produit par son id

function getProductById($productId){
    global $bdd;
    $sql = "SELECT * FROM `products` WHERE id =?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Fonction qui récupère la panier de l'utlisateur connecté

function getCart($userId){
    global $bdd;
    $sql = "SELECT p.id AS product_id, p.name, p.price, c.quantity, p.image_url 
          FROM cart c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id =?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Récupérer les données du panier
function getCartByUserId($userId) {
    global $bdd;
    $stmt = $bdd->prepare('
        SELECT c.id AS cart_id, p.name, p.price, c.quantity, 
               (p.price * c.quantity) AS total_price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :userId
    ');
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Fonction qui récupère tous les produits d'une catégorie

function getProductsByCategory($categoryId){
    global $bdd;
    $sql = "SELECT * FROM `products` WHERE category_id =?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Fonction qui récupère toutes les categeries de la base de donnée

function getAllCategories(){
    global $bdd;
    $sql = "SELECT * FROM `categories`";
    $stmt = $bdd->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction qui crée une historique de commande d'un utilisateur

function createOrderHistory(){
    global $bdd;
    $sql = "SELECT orders.id AS order_number, products.name 
    AS product_name, order_details.quantity, 
    order_details.price AS unit_price, orders.created_at AS order_date,
    orders.status, orders.total_price FROM orders 
    JOIN order_details ON orders.id = order_details.order_id 
    JOIN products ON order_details.product_id = products.id 
    ORDER BY orders.created_at DESC";
    $stmt = $bdd->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Inclusion de la fonction searchProduct
function searchProduct($search){
    global $bdd;
    $sql = "SELECT * FROM `products` WHERE name LIKE ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(["%" . $search . "%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Fonction qui Met ajour la quantité d'un produit dans le panier

function updateQuantity($userId, $productId, $newQuantity){
    global $bdd;
    $updateQuantity = "UPDATE cart SET quantity =? WHERE user_id =? AND product_id =?";
    $stmt = $bdd->prepare($updateQuantity);
    $stmt->execute([$newQuantity, $userId, $productId]);
    return $stmt->rowCount(); // Retourne le nombre de lignes modifiées
}

//Fonction qui supprime un produit du panier

function removeFromCard($userId, $productId){
    global $bdd;
    $deleteProduct = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $bdd->prepare($deleteProduct);
    $stmt->execute([$userId, $productId]);
    return $stmt->rowCount(); // Retourne le nombre de lignes supprimées
}


// Fonction de nettoyage des données utilisateu
// Fonction de nettoyage des données utilisateur
function cleanUserData($data) {
    return htmlspecialchars(stripslashes(trim($data)));
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

        // Vérifications des champs obligatoires
        if (empty($username)) $errors[] = "Le nom d'utilisateur est obligatoire.";
        if (empty($last_name)) $errors[] = "Le nom est obligatoire.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'email n'est pas valide.";
        if (empty($password)) $errors[] = "Le mot de passe est obligatoire.";
        if (strlen($password) < 10) $errors[] = "Le mot de passe doit contenir au moins 10 caractères.";
        if (empty($confirm_password)) $errors[] = "Le mot de passe de confirmation est obligatoire.";
        if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas.";
        if (empty($phone)) $errors[] = "Le numéro de téléphone est obligatoire.";
        if (empty($address)) $errors[] = "L'adresse est obligatoire.";

        // Vérification des formats
        if (!preg_match("/^[a-zA-Z0-9_-]+$/", $username)) $errors[] = "Le nom d'utilisateur ne peut contenir que des lettres, chiffres, underscores et tirets.";
        if (!preg_match("/^[a-zA-Z ]+$/", $last_name)) $errors[] = "Le nom ne peut contenir que des lettres et des espaces.";
        if (!preg_match("/^[0-9]{10,15}$/", $phone)) $errors[] = "Le numéro de téléphone doit contenir uniquement des chiffres et être valide.";
        if (!preg_match("/^[a-zA-Z0-9, -]+$/", $address)) $errors[] = "L'adresse ne peut contenir que des lettres, chiffres, virgules, tirets et espaces.";

        // Vérification de l'existence de l'email
        $checkEmailStmt = $bdd->prepare("SELECT id FROM users WHERE email = :email");
        $checkEmailStmt->execute([':email' => $email]);
        if ($checkEmailStmt->rowCount() > 0) $errors[] = "L'email est déjà utilisé.";

        // Définir le rôle de l'utilisateur si secret_code correct
        if ($secret_code === "admin_code") {
            $role = 'admin';
        }

        // Si des erreurs existent, rediriger avec les erreurs
        // if (!empty($errors)) {
        //     $_SESSION['errors'] = $errors;
        //     header("Location: register.php");
        //     exit();
        // }

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertion de l'utilisateur
            $stmt = $bdd->prepare("INSERT INTO users (username, last_name, email, password, phone, address, role) 
                                   VALUES (:username, :last_name, :email, :password, :phone, :address, :role)");
            $stmt->execute([
                ':username' => $username,
                ':last_name' => $last_name,
                ':email' => $email,
                ':password' => $hashed_password,
                ':phone' => $phone,
                ':address' => $address,
                ':role' => $role
            ]);

            // Stocker les informations de session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $bdd->lastInsertId();
            $_SESSION['user_role'] = $role;

            // Redirection après inscription
            if ($role === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: ../public/profile.php');
            }
            exit();
        } catch (PDOException $e) {
            $_SESSION['errors'][] = "Erreur lors de la création du compte : " . $e->getMessage();
            header("Location: register.php");
            exit();
        }
    }
}

// Fonction pour se loger

function loginUser() {
    global $bdd;
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Nettoyage et validation des données utilisateur
        $email = cleanUserData($_POST['email'] ?? '');
        $password = cleanUserData($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $errors[] = "Veuillez remplir tous les champs.";
        }

        if (empty($errors)) {
            // Vérifier si l'utilisateur existe
            $query = "SELECT id, email, password, role FROM users WHERE email = :email";
            $stmt = $bdd->prepare($query);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérifier si le mot de passe est correct
                if (password_verify($password, $user['password'])) {
                    // Créer une clé de session unique
                    $token = bin2hex(random_bytes(16));

                    // Mettre à jour la clé de session dans la base de données
                    // $updateQuery = "UPDATE users SET session_token = :token WHERE id = :id";
                    // $updateStmt = $bdd->prepare($updateQuery);
                    // $updateStmt->execute(['token' => $token, 'id' => $user['id']]);

                    // Initialiser les variables de session
                    session_start();
                    $_SESSION['session_token'] = $token;
                    $_SESSION['session_expiration'] = time() + 3600; // Expire dans 1 heure
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role'];

                    // Redirection en fonction du rôle de l'utilisateur
                    if ($user['role'] === 'admin') {
                        header('Location: admin_dashboard.php');
                    } else {
                        header('Location: profile.php');
                    }
                    exit;
                } else {
                    $errors[] = "Le mot de passe est incorrect.";
                }
            } else {
                $errors[] = "Aucun utilisateur trouvé avec cet email.";
            }
        }
    }
    
    // Gestion des erreurs
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        header("Location: login.php");
        exit;
    }


    // // Gestion des erreurs
    // if (!empty($errors)) {
    //     if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    //         // Si la requête attend du JSON, renvoyer les erreurs en JSON
    //         header('Content-Type: application/json');
    //         echo json_encode(['errors' => $errors]);
    //     } else {
    //         // Sinon, afficher les erreurs sur la page
    //         foreach ($errors as $error) {
    //             echo "<p style='color:red;'>$error</p>";
    //         }
    //     }
    //     exit;
    // }
}

//Fonction qui vérifie si un utilisateur est connecté

function isUserLoggedIn(){
    return isset($_SESSION['user_id']);
}

//Fonction qui récupère les informations d'un utilisateur connecté

function getUserInfo($userId){
    global $bdd;
    $sql = "SELECT * FROM `users` WHERE id =?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Fonction qui sauvegard l'email du client dans la base de donnée

function save_email($name, $email, $phone, $subject, $message) {
    global $bdd;
    $stmt = $bdd->prepare(
        "INSERT INTO emails (name, email, phone, subject, message) 
        VALUES (:name, :email, :phone, :subject, :message)"
    );
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
    ]);
    return $bdd->lastInsertId(); // Retourne l'ID du message créé
    
}

