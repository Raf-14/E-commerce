
<?php 

//Récupèration des données du panier

// session_start();
include '../config/database.php'; // Inclure la connexion à la base de données
$bdd = bdd();
$userId = $_SESSION['user_id']; // Récupérer l'ID utilisateur

$query = "SELECT p.id AS product_id, p.name, p.price, c.quantity, p.image_url 
          FROM cart c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id = ?";
$stmt = $bdd->prepare($query);
$stmt->execute([$userId]);
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cart); // Retourner le panier sous forme de JSON
?>
