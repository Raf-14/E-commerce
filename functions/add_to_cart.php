<?php 
session_start();
require '../config/database.php';
$bdd = bdd();

function addToCart($data) {
    header('Content-Type: application/json'); // Déclare que la réponse sera en JSON

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        return json_encode(['success' => false, 'message' => 'Vous devez être connecté pour ajouter des produits au panier.']);
    }

    if (!$data || !isset($data['id'], $data['quantity'])) {
        return json_encode(['success' => false, 'message' => 'Données invalides']);
    }

    $productId = $data['id'];
    $quantity = $data['quantity'];
    $userId = $_SESSION['user_id']; // Utilise l'ID de l'utilisateur connecté

    // Connexion à la base de données
    try {
        $bdd = bdd();

        // Vérifier si le produit existe
        $stmt = $bdd->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();

        if (!$product) {
            return json_encode(['success' => false, 'message' => 'Produit non trouvé']);
        }

        if (!is_numeric($quantity) || $quantity <= 0 || !is_numeric($productId)) {
            return json_encode(['success' => false, 'message' => 'Données invalides']);
        }

        // Vérifier si le produit est déjà dans le panier de l'utilisateur
        $stmt = $bdd->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si le produit est déjà dans le panier, met à jour la quantité
            $stmt = $bdd->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Sinon, ajoute le produit au panier
            $stmt = $bdd->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Sauvegarder le panier dans la session
        $stmt = $bdd->prepare("SELECT * FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetchAll();
        $_SESSION['cart'] = $cart;

        return json_encode(['success' => true, 'message' => 'Produit ajouté au panier avec succès.']);

    } catch (PDOException $e) {
        return json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
}

// Utilisation de la fonction pour ajouter un produit au panier
$data = json_decode(file_get_contents('php://input'), true);
$response = addToCart($data);
echo $response;

?>