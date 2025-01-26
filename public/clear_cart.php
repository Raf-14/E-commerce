<?php
session_start();
require_once "../config/database.php";
header('Content-Type: application/json');

// Fonction pour vider le panier d'un utilisateur
function emptyCart($userId) {
    global $bdd;
    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour vider le panier.']);
        exit;
    }

    try {
        $bdd = bdd();
        $stmt = $bdd->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Panier vidé avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
}

// Vérifie et appelle la fonction avec les paramètres appropriés
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    emptyCart($userId);
} else {
    if (!is_numeric($userId)) {
        echo json_encode(['success' => false, 'message' => 'ID utilisateur invalide.']);
        exit;
    }
    
}
?>