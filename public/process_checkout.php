<?php
session_start();
require_once "../config/database.php";

function processOrder($userId, $address, $paymentMethod, $csrfToken) {
    $bdd = bdd();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    // Vérification CSRF
    if (!isset($csrfToken) || $csrfToken !== $_SESSION['csrf_token']) {
        die("Échec de la vérification CSRF.");
    }

    // Validation des données
    $address = trim(htmlspecialchars($address));
    $paymentMethod = trim(htmlspecialchars($paymentMethod));

    if (empty($address) || empty($paymentMethod)) {
        die("Données invalides !");
    }

    // Récupération du panier
    $cart = getCartItems($userId, $bdd);
    if (empty($cart)) {
        die("Votre panier est vide !");
    }

    // Calcul du total
    $totalPrice = array_sum(array_column($cart, 'total_price'));

    try {
        $bdd->beginTransaction();

        // Insertion de la commande
        $stmt = $bdd->prepare("INSERT INTO orders (user_id, address, payment_method, total_price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $address, $paymentMethod, $totalPrice]);
        $orderId = $bdd->lastInsertId();

        // Insertion des articles commandés
        insertOrderDetails($orderId, $cart, $bdd);

        // Suppression du panier
        clearCart($userId, $bdd);

        $bdd->commit();

        // Révoquer le token CSRF après validation
        unset($_SESSION['csrf_token']);

        header("Location: thank_you.php");
        exit;

    } catch (Exception $e) {
        $bdd->rollBack();
        header("Location: error.php?message=" . urlencode("Erreur lors de la commande. Veuillez réessayer."));
        exit;
    }
}

function getCartItems($userId, $bdd) {
    $stmt = $bdd->prepare("
        SELECT c.id AS cart_id, p.id AS product_id, p.price, c.quantity, (p.price * c.quantity) AS total_price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertOrderDetails($orderId, $cart, $bdd) {
    $stmt = $bdd->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
    }
}

function clearCart($userId, $bdd) {
    $stmt = $bdd->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
}

// Exécution de la commande
processOrder($_SESSION['user_id'], $_POST['address'], $_POST['payment_method'], $_POST['csrf_token']);
?>
