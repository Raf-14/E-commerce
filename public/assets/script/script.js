// Récupère le panier actuel depuis localStorage, ou un tableau vide s'il n'existe pas
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Fonction pour ajouter un produit au panier
const addToCart = () => {
    const productId = document.querySelector('#productId').value;
    const productName = document.querySelector('#productName').value;
    const productPrice = parseFloat(document.querySelector('#productPrice').value);
    const quantity = parseInt(document.querySelector('#quantity').value);
    const productImage = document.querySelector('#productImage').value;

    // Vérifier que tous les champs existent
    if (!productId || !productName || isNaN(productPrice) || isNaN(quantity) || !productImage) {
        alert('Veuillez remplir tous les champs du produit.');
        return;
    }

    // Créer un objet produit
    const product = {
        id: productId,
        name: productName,
        price: productPrice,
        quantity: quantity,
        image: productImage
    };

    // Log pour déboguer
    console.log('Produit à envoyer:', product);

    // Utiliser fetch pour envoyer les données au serveur via AJAX
    fetch('../functions/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(product) // Convertir l'objet produit en JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Réponse brute :', text);
        const data = JSON.parse(text);
        if (data.success) {
            console.log(data.message);

            // Récupérer le panier du Local Storage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Vérifier si le produit existe déjà dans le panier
            const existingProductIndex = cart.findIndex(item => item.id === product.id);
            if (existingProductIndex !== -1) {
                cart[existingProductIndex].quantity += product.quantity;
            } else {
                cart.push(product);
            }

            // Sauvegarder le panier mis à jour dans le Local Storage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Si l'ajout au panier est réussi, mettre à jour l'UI du panier
            alert("Produit ajouté au panier !");
            updateCartUI(); // Met à jour l'affichage du panier
        } else {
            console.error(data.error);
            alert(data.error || "Une erreur est survenue.");
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert("Erreur lors de l'ajout au panier.");
    });
};

// Fonction pour mettre à jour l'UI du panier
function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0); // Calculer le nombre total d'articles
    const cartBadge = document.querySelector('#cart-badge');

    if (cartBadge) {
        cartBadge.textContent = cartCount; // Mettre à jour l'affichage du badge
    }
}

// Met à jour le panier dans localStorage et met à jour l'interface
function updateCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload(); // Recharger la page pour mettre à jour le panier (en option)
}

// Fonction pour vider le panier
function clearCart() {
    localStorage.removeItem('cart');
    updateCartUI(); // Mettre à jour l'interface utilisateur
    alert("Le panier a été vidé.");
}

// Fonction pour mettre à jour l'UI du panier
function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0); // Calculer le nombre total d'articles
    const cartBadge = document.querySelector('#cart-badge');

    if (cartBadge) {
        cartBadge.textContent = cartCount; // Mettre à jour l'affichage du badge
    }
}

// Lier l'événement "Vider le panier" au bouton (supposons que vous avez un bouton pour cela)
const clearButton = document.querySelector('#clear-cart-btn');
if (clearButton) {
    clearButton.addEventListener('click', clearCart);
}

// Autres fonctions existantes comme `addToCart` restent les mêmes
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le panier du Local Storage et mettre à jour l'UI du panier
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartUI(cart);

    // Appelle de la fonction addToCart lors du clic
    const addButton = document.querySelector('#add-to-cart-btn');
    if (addButton) {
        addButton.addEventListener('click', addToCart);
    }
});

