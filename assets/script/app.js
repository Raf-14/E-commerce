// JavaScript pour le menu burger
// JavaScript pour le menu burger
// const mobileMenu = document.getElementById('mobile-menu'); // Le bouton burger
// const navbar = document.querySelector('.navbar ul'); // Liste de navigation

// Ajoute ou enlève la classe 'active' lors du clic sur le bouton burger
// mobileMenu.addEventListener('click', () => {
//     navbar.classList.toggle('active'); // Toggle la classe 'active' pour afficher ou masquer le menu
//     mobileMenu.classList.toggle('active'); // Change l'état visuel du burger (optionnel)
// });


// JavaScript pour la carte interactive
//fetch des donnée depuis le fichier json avec la methode promise
const data = "http://localhost/E-commerce/produits.json";

// Fonction pour créer une carte de produit
const createCard = (product) => {
    const productContainer = document.getElementById('product-container');
    const card = document.createElement('div');
    card.classList.add('card');
    card.innerHTML = `
        <img src="${product.image}" alt="${product.name}">
        <h2>${product.name}</h2>
        <p>${product.description}</p>
        <a href="#" class="btn">Voir plus</a>
        <p class="price">${product.price} €</p>
        <button class="add-to-cart">Ajouter au panier</button>

        <div class="rating">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
        </div>
    `;
    productContainer.appendChild(card);

    // Gestion du bouton "Ajouter au panier"
    const addToCartBtn = card.querySelector('.add-to-cart');
    addToCartBtn.addEventListener('click', () => {
        console.log('Ajouté au panier:', product.name);
    });

    // Gestion des étoiles de notation
    const ratingStars = card.querySelectorAll('.rating .fa-star');
    ratingStars.forEach((star, index) => {
        star.addEventListener('click', () => {
            for (let i = 0; i < ratingStars.length; i++) {
                if (i <= index) {
                    ratingStars[i].classList.add('checked');
                } else {
                    ratingStars[i].classList.remove('checked');
                }
            }
        });
    });

    // Bouton "Voir plus"
    const btnVoirPlus = card.querySelector('.btn');
    btnVoirPlus.addEventListener('click', () => {
        console.log('Voir plus:', product.name);
    });
};

// Fetch des données depuis le fichier JSON
const fetchData = new Promise((resolve, reject) => {
    if (data) {
        fetch(data)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => resolve(data))
            .catch(error => reject(error))
            .finally(() => {
                console.log("Fetch terminé");
            });
    } else {
        console.log("Le fichier json n'existe pas");
        reject("Le fichier json n'existe pas");
    }
}).then(result => {
    console.log("Données reçues :", result); // Traite les données ici
    result.forEach(product => {
        createCard(product); // Crée une carte pour chaque produit
    });
}).catch(error => {
    console.log("Erreur :", error); // Gestion des erreurs
});
