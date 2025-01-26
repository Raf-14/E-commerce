<?php
if (session_status() == 'PHP_SESSION_NONE') {
    session_start();
}
require_once "../config/database.php";
require_once "../functions/functions.php";
$bdd = bdd();
//Session d'id de l'utilisateur
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        // echo "Veuillez vous connecter pour voir les détails du produit.";
        //redirection à login
        header('Location: login.php');
        exit;
    }

$product = getProductById($_GET['id']);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
</head>
<body>
    <!-- Header call since include -->
     <?php include '../includes/header.php'?>

<!-- Section de produit -->
<div class="product-detail">
    <img src="<?php echo htmlspecialchars($product['image_url']) ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" class="product-image">
    
    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['name']) ?></h1>
        <p><?php echo htmlspecialchars($product['description']) ?></p>
        <h3><strong>Stock: <?php echo htmlspecialchars($product['stock']) ?> </strong></h3>
        <h4><strong><?php echo htmlspecialchars($product['price']) ?> <span>€</span></strong></h4>
        <div class="container-quantity">
            <label for="quantity">Quantité:</label>
            <button type="button" class="plus quantity-btn" onclick="addQuantity()">+</button>
            <input type="hidden" id="productImage" name="productImage" value="<?= htmlspecialchars($product['image_url']) ?>">
            <input type="hidden" name="productName" id="productName" value="<?= htmlspecialchars($product['name']) ?>">
            <input type="hidden" id="productId" value="<?php echo htmlspecialchars($product['id']) ?>">
            <input type="hidden" id="productPrice" value="<?php echo htmlspecialchars($product['price']) ?>">
            <input type="number" id="quantity" name="quantity" value="1" min="1">
            <button type="button" class="minus quantity-btn" onclick="removeQuantity()">-</button>
        </div>

        <div class="container-btn">
            <a href="shop.php" class="retourne-btn">Liste des produits</a>
            <button type="button" id="add-to-cart-btn" class="add-to-cart">Ajouter au panier</button>
        </div>
    </div>
</div>

    

    <!-- Footer call since include -->
     <?php include '../includes/footer.php'?>

    <script>
            // Ajout d'un produit, retrait d'u produit pour la quantité
        // Fonction pour ajouter la quantité
            const addQuantity = () => {
                const quantityInput = document.querySelector('#quantity');
                let currentQuantity = parseInt(quantityInput.value);
                quantityInput.value = currentQuantity + 1;

                // Enregistre la quantité dans le localStorage
                const product = JSON.parse(localStorage.getItem('product'));
                localStorage.setItem('product', JSON.stringify({...product, quantity: currentQuantity }));
            }

    // Fonction pour enlever la quantité
            const removeQuantity = () => {
                    const quantityInput = document.querySelector('#quantity');
                    let currentQuantity = parseInt(quantityInput.value);
                    if (currentQuantity > 1) {  // Empêche la quantité de devenir inférieure à 1
                        quantityInput.value = currentQuantity - 1;
                        // Enregistre la quantité dans le localStorage
                        const product = JSON.parse(localStorage.getItem('product'));
                        localStorage.setItem('product', JSON.stringify({...product, quantity: currentQuantity }));

                    }
            }
    </script>
   
     <script  src="./assets/script/app.js"></script>
     <script  src="./assets/script/script.js"></script> 
     <script  src="./assets/script/function.js"></script>
</body>
</html>
