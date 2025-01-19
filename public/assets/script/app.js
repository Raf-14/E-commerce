
// JavaScript pour le menu burger
const mobileMenu = document.getElementById('mobile-menu');
const navbar = document.querySelector('.navbar ul');

// Ajoute ou enlève la classe 'active' lors du clic sur le bouton burger
mobileMenu.addEventListener('click', () => {
    navbar.classList.toggle('active'); 
    mobileMenu.classList.toggle('active');
});

// Données JSON
const data = "http://localhost/E-commerce/produits.json";

// Fonction pour créer une carte de produit
const createCard = (product) => {
    const productContainer = document.getElementById('product-container');
    const card = document.createElement('div');
    card.classList.add('card');
    card.innerHTML = `
        <img src="${product.image_url}" alt="${product.name}">
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

        // Afficher le modal avec les détails du produit
        const modal = document.getElementById('productModal');
        modal.style.display = "block";
        const productDetails = document.getElementById('product-details');
        productDetails.innerHTML = `
            <h5>${product.name}</h5>
            <p>${product.description}</p>
            <img src="${product.image_url}" alt="${product.name}">
            <p>Prix: ${product.price} €</p>
            <p>Stock: ${product.stock} unités</p>
            <p>Catégorie: ${product.category_id}</p>
            <button class="btn-primary">Commander</button>
            <button type="button" class="btn" id="closeModal">Fermer</button>
            <button type="button" class="btn add-to-cart">Ajouter au panier</button>
        `;

        // Gestion du bouton "Fermer"
        const closeModalBtn = document.getElementById('closeModal');
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = "none";
        });

        // Gestion du bouton "Commander"
        const commanderBtn = productDetails.querySelector('.btn-primary');
        commanderBtn.addEventListener('click', () => {
            console.log('Commandé:', product.name);
        });

        // Gestion du bouton "Ajouter au panier"
        const addToCartBtnModal = productDetails.querySelector('.add-to-cart');
        addToCartBtnModal.addEventListener('click', () => {
            console.log('Ajouté au panier:', product.name);
        });
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
    console.log("Données reçues :", result);
    result.forEach(product => {
        createCard(product); // Crée une carte pour chaque produit
    });
}).catch(error => {
    console.log("Erreur :", error); // Gestion des erreurs
});
