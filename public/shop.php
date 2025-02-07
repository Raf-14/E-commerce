<?php
if (session_status() == 'PHP_SESSION_NONE') {
    session_start();
}
require_once '../config/database.php';
require_once '../functions/functions.php';
$bdd = bdd();

//Appel des fonctions
$categories = getAllCategories();

// Traitement du formulaire de recherche
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    // Récupération du mot-clé de recherche via GET
    $search = htmlspecialchars(trim($_GET['search'])); // Protection contre XSS
    
    if (!empty($search)) {
        // Appel de la fonction de recherche
        $products = searchProduct($search);
    } else {
        // Si la barre de recherche est vide, afficher tous les produits
        $products = getAllProducts();
    }
} else {
    // Si aucun formulaire n'est soumis, afficher tous les produits par défaut
    $products = getAllProducts();
} 

// Récupération du produit grâce à l'id via GET
     $productId = ($_SESSION['user_id']); // Exemple avec un id de produit précis
     $product = getProductById($productId); // Appel de la fonction pour récupérer le produit grâce à son id



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Alimentaire</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<!-- En-tête -->
    <?php include '../includes/header.php' ?>

            <!-- Section de recherche -->
        <div class="search">
            <form class="search-form" action="" method="GET">
                <input type="text" name="search" placeholder="Rechercher..." required>
                <button type="submit" class="search-button">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.9 11.9h-.8l-.3-.3c1-1.2 1.6-2.6 1.6-4.1C13.4 3.5 10.9 1 7.7 1 4.5 1 2 3.5 2 6.7c0 3.2 2.5 5.7 5.7 5.7 1.5 0 2.9-.6 4.1-1.6l.3.3v.8l4.9 4.9 1.5-1.5-4.9-4.9zM7.7 11C5.6 11 4 9.4 4 7.3c0-2.1 1.6-3.7 3.7-3.7 2.1 0 3.7 1.6 3.7 3.7 0 2.1-1.6 3.7-3.7 3.7z" fill="#000"/>
                    </svg>
                </button>
            </form>
        </div>


     <!-- Affichage du Résultat de la recherche -->
        <?php if (!empty($products) && isset($search)) : ?>
            <h2>Résultat de la recherche pour "<?= htmlspecialchars($search) ?>"</h2>
        <?php endif; ?>


    <!-- <div class="filling"></div> -->
        
    <select class="category-dropdown" name="category_id">
                <option value="">Tous les produits</option>
                <?php foreach ($categories as $category) :?>
                    <option value="<?php echo htmlspecialchars($category['id'])?>"><?php echo htmlspecialchars($category['name'])?></option>
                <?php endforeach;?>
    </select>
    <!-- Section pour afficher les grid de filtre de cathégorie d'aliment -->
     <?php 
        //Vérification si la table categorie n'est pas vide avant d'afficher
        if (!empty($categories)) :?>
            <div class="filter">
                <h2>Filtrer par catégorie</h2>
                <ul>
                    <?php foreach ($categories as $category) :?>
                        <li><a href="shop.php?category_id=<?= htmlspecialchars($category['id'])?>"><?= htmlspecialchars($category['name'])?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endif;
        ?>

    <!-- card shop -->
     <!-- Affichage des produits disponible depuis la base de donnée -->
       <div class="container-card">
        <?php  // Vérifier si des produits sont disponibles
            if (empty($products)) :?>
                <p>Aucun produit disponible pour le moment.</p>
            <?php endif;?>

            <?php  // Si des produits sont disponibles, afficher les cartes avec le nom, description, image et prix
                    // Parcourir les produits et afficher chaque card avec le nom, description, image et prix
            foreach ($products as $product) :?>
            <div class="card">
                <img src="<?= htmlspecialchars($product['image_url'])?>" alt="<?= htmlspecialchars($product['name'])?>">
                <h2><?= htmlspecialchars($product['name'])?></h2>
                <p><?= htmlspecialchars($product['description'])?></p>
                <h4>Prix : <?= htmlspecialchars($product['price'])?> <span>€</span></h4>
                <a href="product.php?id=<?=$product['id']?>">Voir plus</a>
                <button type="button" id="add-to-cart-btn" class="add-to-cart" data-id="<?php echo $product['id']?>">Ajouter au panier</button>
                <div class="form-to-add">
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" id="productImage" name="productImage" value="<?= htmlspecialchars($product['image_url']) ?>">
                        <input type="hidden" name="productName" id="productName" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" id="productId" name="productId" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" id="quantity" name="quantity" value="1">
                        <input type="hidden" id="productPrice" name="productPrice" value="<?= htmlspecialchars($product['price']) ?>">
                        <!-- <button type="submit">Ajouter au panier</button> -->
                    </form>
                </div>               
            </div>
           

            <!-- <div class="form-add-to-cart">
                <form id="form-add-to-cart-<?=$product['id']?>" action="add_to_cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $product['id']?>">
                    <input type="number" name="quantity" min="1" placeholder="Quantité">
                    <button type="submit" class="btn-add-to-cart">Ajouter au panier</button>
                </form>
                <button type="button" class="close-btn" data-id="<?php echo $product['id']?>">X</button>
            </div>
            -->
            <?php endforeach;?> 
        </div>
 
    <!-- Footer -->
     <?php include '../includes/footer.php'?>
     <script src="./assets/script/app.js"></script>
    <script src="./assets/script/function.js"></script>
    <script src="./assets/script/script.js"></script>
</body>
</html>

    