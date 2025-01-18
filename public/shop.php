<?php
require_once '../config/database.php';
$bdd = bdd()

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
     <section class="search">
        <form class="search-form" action="search.php" method="get">
            <input type="text" name="query" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
        </form>
    </section>

    <!-- card shop -->
     <!-- Affichage des produits disponible depuis la base de donnée -->
      <?php
       $query = $conn->query('SELECT * FROM products');
       $products = $query->fetchAll(PDO::FETCH_ASSOC);
       ?>
       <div class="container-card">
        <?php  // Vérifier si des produits sont disponibles
            if (empty($products)) :?>
                <p>Aucun produit disponible pour le moment.</p>
            <?php endif;?>

            <?php  // Si des produits sont disponibles, afficher les cartes avec le nom, description, image et prix
       // Parcourir les produits et afficher chaque card avec le nom, description, image et prix
            foreach ($products as $product) :?>
            <div class="card">
                <img src="<?php echo $product['image_url']?>" alt="<?php echo $product['name']?>">
                <h2><?php echo $product['name']?></h2>
                <p><?php echo $product['description']?></p>
                <p>Prix : <?php echo $product['price']?> €</p>
                <a href="product.php?id=<?php echo $product['id']?>">Voir plus</a>
            </div>
            <?php endforeach;?> 
        </div>



   
    <!-- Footer -->
     <?php include '../includes/footer.php'?>
   

    <script src="./assets/script/app.js"></script>
</body>
</html>

    