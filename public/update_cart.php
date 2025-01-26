<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['product_id'];
$quantity = $data['quantity'];
$userId = $_SESSION['user_id'];

try {
    $bdd = bdd();
    if ($quantity <= 0) {
        // Supprimer l'article du panier
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$userId, $productId]);
    } else {
        // Mettre à jour la quantité
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$quantity, $userId, $productId]);
    }
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}