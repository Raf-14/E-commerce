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

    <!-- Bannière principale -->
    <section class="hero">
        <div class="hero-content">
            <h1>Des produits frais, locaux et bio, livrés chez vous !</h1>
            <a href="shop.php" class="cta-btn">Explorer notre shop</a>
        </div>
    </section>

    <!-- À propos -->
    <section class="about">
        <h2>Qui sommes-nous ?</h2>
        <p>Nous croyons que vous méritez des produits frais, locaux et de qualité. Nous travaillons avec des fermes locales pour vous offrir ce qu'il y a de mieux.</p>
        <a href="#">En savoir plus</a>
    </section>

    <!-- Produits en vedette -->
    <section class="featured-products">
        <h2>Nos produits frais de la semaine</h2>
        <div class="products-grid">
            <div class="product-item">
                <img src="./assets/images/aliments/avocado.jpeg" alt="Fruit 1">
                <p>Fruits de saison</p>
                <p>€5.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">
                <img src="./assets/images/fruits/banane.jpeg" alt="Fruit 2">
                <p>Légumes frais</p>
                <p>€3.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">    
                <img src="./assets/images/aliments/Chili_Peppers.jpeg" alt="Fruit 4">
                <p>Chili Peppers</p>
                <p>€12.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">    
            <img src="./assets/images/produit_frais/Jus_d_Ananas_Pur.jpeg" alt="Fruit 3">
                <p>Jus d'Ananas frais</p>
                <p>€4.49</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">
                <img src="./assets/images/produit_frais/Jus_de_Fraise_Pur.jpeg" alt="Fruit 5">
                <p>Fruits de Fraise Pur</p>
                <p>€6.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">
                <img src="./assets/images/produit_frais/Pur_jus_de_citron.jpeg" alt="Fruit 6">
                <p>Jus de citron</p>
                <p>€8.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">
                <img src="./assets/images/aliments/carotte.jpeg" alt="Fruit 7">
                <p>Carotte</p>
                <p>€10.99</p>
                <button>Ajouter au panier</button>
            </div>
            <div class="product-item">
                <img src="./assets/images/fruits/Melon.jpeg" alt="Fruit 8">
                <p>Melon</p>
                <p>€7.99</p>
                <button>Ajouter au panier</button>
            </div>

        </div>
        <a href="shop.php" class="cta-btn">Voir plus de produits</a>
    </section>
    
    <!-- <div id="product-container" class="products-grid"></div> -->
     <!-- Modal -->
     <div class="modal fade" id="productModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Détail du produit</h5>
                    <button type="button" id="closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="product-details">
                        <!-- Les informations du produit seront affichées ici -->
                    </div>
                </div>
                
            </div>
        </div>
      </div>
      
    <div class="product-container">
    <?php
        // Lire le fichier JSON
        //$json = file_get_contents('../produits.json');  // Si le fichier JSON est à la racine du projet
       // $produits = json_decode($json, true);  // Décoder le JSON en tableau associatif

        // Parcourir les produits et afficher
       // foreach ($produits as $produit) {
         //   echo '<div>';
         //   echo '<img src="' . htmlspecialchars($produit['image_url']) . '" alt="' . htmlspecialchars($produit['name']) . '" />';
          //  echo '<h3>' . htmlspecialchars($produit['name']) . '</h3>';
          //  echo '<p>' . htmlspecialchars($produit['description']) . '</p>';
           // echo '<p>Price: ' . htmlspecialchars($produit['price']) . ' €</p>';
           // echo '<p>Stock: ' . htmlspecialchars($produit['stock']) . '</p>';
           // echo '</div>';
       // }
        ?>
    </div>

    <!-- Témoignages -->
    <section class="testimonials">
        <h2>Ce que nos clients disent</h2>
        <div class="testimonial-item">
            <p>"Des produits incroyablement frais et une livraison rapide !"</p>
            <p>- Client heureux</p>
        </div>
        <div class="testimonial-item">
            <p>"J'adore la qualité des fruits et légumes, je recommande vivement !"</p>
            <p>- Client satisfait</p>
        </div>
    </section>

    <!-- Offres spéciales -->
    <section class="special-offers">
        <h2>Offres spéciales du moment</h2>
        <p>Panier de fruits à -20%</p>
        <p>Promo sur les légumes de saison !</p>
        <a href="#" class="cta-btn">Profitez de nos offres</a>
    </section>

    <!-- Footer -->
     <?php include '../includes/footer.php'?>
   

    <script src="./assets/script/app.js"></script>
    <script src="./assets/script/function.js"></script>
    <script src="./assets/script/script.js"></script>
</body>
</html>

    