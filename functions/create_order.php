<?php 
session_start();
require '../config/database.php';
$bdd = bdd();


//2. Passer à la Caisse

//Fonction pour crée une commande

function createOrder($userId, $cart){

    global $bdd;

    //Calculer le total de la commande
    $total = 0;
    foreach($cart as $item){
       $total += $item['price'] * $item['quantity'];
    }

    //Créer la commande
    $createOrder = "INSERT INTO orders (user_id, total_price) VALUES (?,?)";
    $stmt = $bdd->prepare($createOrder);
    $stmt->execute([$userId, $total]);
    $orderId = $bdd->lastInsertId(); // Retourne l'ID de la commande créée

    //Ajouter les produits de la commande
    foreach($cart as $item){
        $insertOrderItem = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)";
        $stmt = $bdd->prepare($insertOrderItem);
        $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
    }
    //Vider le panier
    $deleteCart = "DELETE FROM cart WHERE user_id =?";
    $stmt = $bdd->prepare($deleteCart);
    $stmt->execute([$userId]);
    return $orderId; // Retourne l'ID de la commande créée
}