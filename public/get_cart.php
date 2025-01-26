<?php
// Empêcher la mise en cache
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: application/json');

// Nettoyer tous les buffers de sortie
while (ob_get_level()) {
    ob_end_clean();
}

session_start();
require_once "../config/database.php";

// Connexion à la base de données
$bdd = bdd();
// Désactiver toute sortie avant le json_encode
// ob_clean();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');

// Vérifier si un utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous n\'êtes pas connecté.']);
    exit;
}

// Utilisateur connecté
$userId = $_SESSION['user_id'];

try {
    $bdd = bdd(); // Connexion à la base de données
    $sql = "SELECT products.id, products.name, products.price, cart.quantity, products.image_url 
            FROM cart
            JOIN products ON cart.product_id = products.id
            WHERE cart.user_id = ?";
    
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si le panier est vide
    if (empty($cartItems)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Votre panier est vide.'
        ]);
    } else {
        echo json_encode([
            'success' => true, 
            'cart' => $cartItems
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur : ' . $e->getMessage()
    ]);
}