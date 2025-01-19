<?php
require_once "../config/database.php";
$bdd = bdd();

// Vérifier si une catégorie a été passée dans l'URL
    // if (isset($_GET['category'])) {
    //     $categoryId = $_GET['category'];

    //     // Connexion à la base de données
    //     // (Assurez-vous d'avoir correctement configuré la connexion à la base de données)
    //     $query = $bdd->prepare('SELECT * FROM products WHERE category_id = :categoryId');
    //     $query->execute(['categoryId' => $categoryId]);
    //     $products = $query->fetchAll(PDO::FETCH_ASSOC);

    //     // Vérifier si des produits correspondent à la catégorie dans la base de données
    //     if (empty($products)) {
    //         echo "Aucun produit dans cette catégorie.";
    //         exit;
    //     }
    // } else {
    //     echo "Aucune catégorie sélectionnée.";
    //     exit;
    // }
    // // Afficher les détails du produit
    // echo '<div class="product-detail">';
    // echo '<img src="'. $product['image_url']. '" alt="'. $product['name']. '">';
    // echo '<h2>'. $product['name']. '</h2>';
    // echo '<p>'. $product['description']. '</p>';
    // echo '<p>Prix: '. $product['price'].'���</p>';
    // echo '<a href="shop.php">Retour à la liste des produits</a>';
    // echo '</div>';

// Vérifier si un ID de produit a été passé dans l'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Connexion à la base de données
    // (Assurez-vous d'avoir correctement configuré la connexion à la base de données)
    $query = $bdd->prepare('SELECT * FROM products WHERE id = :id');
    $query->execute(['id' => $productId]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le produit existe dans la base de données
    if (!$product) {
        echo "Produit introuvable.";
        exit;
    }
} else {
    echo "Aucun produit sélectionné.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <style>

@media (max-width: 768px) {
    /* Si la largeur de l'écran est inférieure à 768px, les styles suivants seront appliqués */
   .product-detail {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 20px;
    gap: 20px;
   }
   
   .product-detail img {
    max-width: 100%;
    height: auto;
    }
    .product-detail .product-info {
    flex: 1;
    text-align: center;
    }
    .product-detail h1 {
    font-size: 24px;
    }
    .product-detail p {
    font-size: 16px;
    }
    .product-detail .add-to-cart {
    width: 100%;
    margin-top: 10px;
    }
    .product-detail .add-to-cart:hover {
    background-color: #555;
    color: #fff;
    }
    .product-info .retourne-btn {
    width: 100%;
    margin-top: 0;
    }
    .container-btn {
    flex-direction: column;
    }
    .container-btn {
    gap: 10px;
    margin-top: 10px;
    }
}

@media (max-width: 576px) {
    /* Si la largeur de l'écran est inférieure à 576px, les styles suivants seront appliqués */
   .product-detail {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 10px;
    gap: 10px;
    }
    .product-detail img {
    max-width: 100%;
    height: auto;
    }
    .product-detail .product-info {
    flex: 1;
    text-align: center;
    }
    .product-detail h1 {
    font-size: 20px;
    }
    .product-detail p {
    font-size: 14px;
    }
    .product-detail .add-to-cart {
    width: 100%;
    margin-top: 10px;
    }
    .product-detail .add-to-cart:hover {
    background-color: #555;
    color: #fff;
    }
    .product-info .retourne-btn {
    width: 100%;
    margin-top: 0;
    }
    .container-btn {
    flex-direction: column;
    }
}
    </style>
    <link rel="stylesheet" href="./assets/style/style.css">
</head>
<body>
    <!-- Header call since include -->
     <?php include '../includes/header.php'?>

     <div class="product-detail">
        <img src="<?php echo $product['image_url'] ?>" alt="<?php echo $product['name'] ?>" class="product-image">
    
    <div class="product-info">
            <h1><?php echo $product['name'] ?></h1>
            <p><?php echo $product['description'] ?></p>
            <h3><strong>Stock: <?php echo $product['stock']?> </strong></h3>
            <h4><strong> <?php echo $product['price'] ?> <span>€</span></strong></h4>
            <div class="container-quantity">
                <label for="quantity">Quantité:</label>
                <!-- plus -->
                <button type="button" class="plus quantity-btn" onclick="addQuatity()">+</button>
                <!-- input -->
                 <input type="hidden" id="pruductImage" name="productImage" value="<?= $product['image_url'] ?>">
                 <input type="hidden" name="productName" id="productName"value="<?= $product['name']?>">
                <input type="hidden" id="productId" value="<?php echo $product['id']?>">
                <input type="hidden" id="productPrice" value="<?php echo $product['price']?>">
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <!-- minus -->
                <button type="button" class="minus quantity-btn" onclick="removeQuatity()">-</button>
                
            </div>


            <div class="container-btn">
                <a href="shop.php" class="retourne-btn">Liste des produits</a>
                <!-- Bouton "Ajouter au panier" -->
                <button type="button" id="add-to-cart-btn" class="add-to-cart">Ajouter au panier</button>
            </div>
        </div>
    </div>


    <!-- Footer call since include -->
     <?php include '../includes/footer.php'?>
    <script>
            // Ajout d'un produit, retrait d'u produit pour la quantité
        // Fonction pour ajouter la quantité
  const addQuatity = () => {
        const quantityInput = document.querySelector('#quantity');
        let currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;

        // Enregistre la quantité dans le localStorage
        // const product = JSON.parse(localStorage.getItem('product'));
        // localStorage.setItem('product', JSON.stringify({...product, quantity: currentQuantity }));
    }

    // Fonction pour enlever la quantité
 const removeQuatity = () => {
        const quantityInput = document.querySelector('#quantity');
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {  // Empêche la quantité de devenir inférieure à 1
            quantityInput.value = currentQuantity - 1;
            // Enregistre la quantité dans le localStorage
            // const product = JSON.parse(localStorage.getItem('product'));
            // localStorage.setItem('product', JSON.stringify({...product, quantity: currentQuantity }));

        }
    }

  // Fonction pour mettre à jour l'UI du panier
     function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    const cartBadge = document.querySelector('#cart-badge');
    if (cartBadge) {
        cartBadge.textContent = cartCount;
    }
}
    </script>
     <script  src="./assets/script/app.js"></script>
     <script  src="./assets/script/script.js"></script> 
     <script  src="./assets/script/function.js"></script> 
</body>
</html>
