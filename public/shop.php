<?php
// public/index.php

require_once '../config/database.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Alimentaire</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
       
   /* Style pour le container des cartes de produits */
.container-card {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Par défaut 4 cartes par ligne */
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
    justify-items: center;
    gap: 10px;
}

/* Style pour les cartes de produits */
.card { 
    padding: 10px;
    width: 100%; /* La carte occupe toute la largeur de son conteneur */
    height: 300px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    cursor: pointer;
    gap: 50px;
    border-radius: 5px;
    margin-top: 100px;
    

}

/* Style pour les images des produits */

.card img {
    width: 100%;
    height: 80%;
    object-fit: cover;
}

/* Style pour les cartes de produits lors du hover */
/* .card:hover {
    transform: scale(1.05);
} */

/* Style pour les cartes de produits lors du click */
.card:active {
    transform: scale(1);
}

/* Style pour les titres des produits */
.card h2 {
    font-size: 1.2em;
    margin: 10px 0;
}

/* Style pour les descriptions de produits */
.card p {
    font-size: 1em;
    color: #555;
}

/* Style pour le lien Voir plus */
.card a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: bold;
}

.card a:hover {
    text-decoration: underline;
}

/* Responsive : Pour les tablettes, 2 cartes par ligne */
@media (max-width: 768px) {
    .container-card {
        grid-template-columns: repeat(2, 1fr); /* 2 cartes par ligne */
    }
}

/* Responsive : Pour les téléphones, 1 carte par ligne */
@media (max-width: 480px) {
    .container-card {
        grid-template-columns: 1fr; /* 1 carte par ligne */
    }
}

    
    /* Style pour le lien de voir plus */
    a {
        text-decoration: none;
        color: #007bff;
        font-size: 1.1rem;
    }
    
    /* Style pour la section de recherche */
    section.search {
        margin-top: 30px;
    }
    
    /* Style pour le formulaire de recherche */
    form.search-form {
        display: flex;
        align-items: center;
    }
    
    /* Style pour le champ de recherche */
    input[type="text"] {
        padding: 10px;
        width: 200px;
        border-radius: 5px;
    }
    
    /* Style pour le bouton de recherche */
    button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style pour la section de contact */
    section.contact {
        margin-top: 30px;
    }
    
    /* Style pour le formulaire de contact */
    form.contact-form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    /* Style pour les champs du formulaire de contact */
    input[type="text"],
    input[type="email"],
    textarea {
        padding: 10px;
        width: 300px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    
    /* Style pour le bouton de soumission du formulaire de contact */
    button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    /* style lors du survole du button */
    button[type="submit"]:hover {
        background-color: #0069d9;
    }
    

    </style>
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
                <img src="<?php echo $product['image']?>" alt="<?php echo $product['name']?>">
                <h2><?php echo $product['name']?></h2>
                <p><?php echo $product['description']?></p>
                <p>Prix : <?php echo $product['price']?> €</p>
                <a href="product.php?id=<?php echo $product['id']?>">Voir plus</a>
            </div>
            <?php endforeach;?> 
        </div>



   
    <!-- Footer -->
     <?php include '../includes/footer.php'?>
   

    <script src="../assets/script/app.js"></script>
</body>
</html>

    