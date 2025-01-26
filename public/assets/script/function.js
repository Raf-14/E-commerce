document.addEventListener('DOMContentLoaded', function () {
    
    const userId = "<?php echo $_SESSION['user_id']; ?>"; // Récupère l'ID de l'utilisateur depuis PHP

    // Fonction pour récupérer et afficher les produits du panier
    function fetchAndDisplayCart() {
        fetch(`./get_cart.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Vérifie les données renvoyées
                const cartContainer = document.querySelector('.cart'); // Div où afficher le panier

                if (data.success === false) {
                    cartContainer.innerHTML = `
                        <div class="container-empty">
                            <img src="./assets/images/Panier_Vide.jpg" alt="Panier vide" class="cart-image">
                            <p>${data.message}</p>
                        </div>
                    `;
                    return;
                }

                const cartItems = data.cart; // Les articles du panier

                // Vider le contenu existant du panier
                cartContainer.innerHTML = '';

                // Ajouter le titre du panier
                const title = document.createElement('h1');
                title.textContent = 'Mon Panier';
                cartContainer.appendChild(title);

                // Ajouter les actions du panier (avant d'ajouter des boutons)
                const cartActions = document.createElement('div');
                cartActions.classList.add('cart-actions');

                // Ajouter le bouton "Vider le panier"
                const clearCartBtn = document.createElement('button');
                clearCartBtn.textContent = 'Vider le panier';
                clearCartBtn.classList.add('clear-cart-btn');
                clearCartBtn.addEventListener('click', clearCart);
                cartActions.appendChild(clearCartBtn);


                let subtotal = 0;
                cartItems.forEach(item => {
                    const productTotal = item.price * item.quantity;
                    subtotal += productTotal;

                    // Créer un élément pour chaque produit
                    const cartItem = document.createElement('div');
                    cartItem.classList.add('cart-item');

                    // Ajouter l'image du produit
                    const img = document.createElement('img');
                    img.src = item.image_url;
                    img.alt = item.name;
                    img.classList.add('item-image');
                    cartItem.appendChild(img);

                    // Détails du produit
                    const itemDetails = document.createElement('div');
                    itemDetails.classList.add('item-details');

                    const productName = document.createElement('h3');
                    productName.textContent = item.name;
                    itemDetails.appendChild(productName);

                    const price = document.createElement('p');
                    price.textContent = `Prix : ${item.price}€`;
                    itemDetails.appendChild(price);
                    // Dans la boucle forEach des cartItems
                    const quantityContainer = document.createElement('div');
                    quantityContainer.classList.add('quantity-controls');

                    const decreaseBtn = document.createElement('button');
                    decreaseBtn.textContent = '-';
                    decreaseBtn.onclick = () => updateQuantity(item.id, Math.max(0, item.quantity - 1));

                    const quantityDisplay = document.createElement('span');
                    quantityDisplay.textContent = item.quantity;
                    quantityDisplay.classList.add('quantity-display');

                    const increaseBtn = document.createElement('button');
                    increaseBtn.textContent = '+';
                    increaseBtn.onclick = () => updateQuantity(item.id, item.quantity + 1);

                    quantityContainer.appendChild(decreaseBtn);
                    quantityContainer.appendChild(quantityDisplay);
                    quantityContainer.appendChild(increaseBtn);

                    itemDetails.appendChild(quantityContainer);
                    // Ajouter au panier
                    cartItem.appendChild(itemDetails);
                    cartContainer.appendChild(cartItem);

                   // Création du bouton de suppression complet du produit dans le panier
                    const deleteBtn = document.createElement('button'); // Bouton de suppression
                    const delImg = document.createElement('img'); // Image pour le bouton

                    // Configuration de l'image
                    delImg.src = './assets/images/Trash.jpg'; // Chemin de l'image
                    delImg.alt = 'Supprimer'; // Texte alternatif
                    delImg.classList.add('delete-icon'); // Optionnel : ajoute une classe CSS à l'image
                    //Effacer le produit dans le localStorage lors du click
                    deleteBtn.addEventListener('click', () => {
                        if (window.confirm('Voulez-vous supprimer définitivement cet article?')) {
                            updateQuantity(item.id, 0);
                        }
                    });
                    // Ajout de l'image dans le bouton
                    deleteBtn.appendChild(delImg); 
                   
                    // Ajout du bouton dans le conteneur des détails de l'item
                    itemDetails.appendChild(deleteBtn);

                    // Ajout du bouton dans le conteneur de quantité, si nécessaire
                    quantityContainer.appendChild(deleteBtn);

                });

                // Ajouter le résumé du panier
                const cartSummary = document.createElement('div');
                cartSummary.classList.add('cart-summary');

                const subtotalElem = document.createElement('p');
                subtotalElem.classList.add('subtotal');
                subtotalElem.textContent = `Sous-total : ${subtotal.toFixed(2)}€`;
                cartSummary.appendChild(subtotalElem);

                const shippingElem = document.createElement('p');
                shippingElem.classList.add('shipping');
                const shippingCost = 5; // Exemple de frais de livraison
                shippingElem.textContent = `Frais de livraison : ${shippingCost.toFixed(2)}€`;
                cartSummary.appendChild(shippingElem);

                const totalElem = document.createElement('p');
                totalElem.classList.add('total');
                totalElem.textContent = `Total : ${(subtotal + shippingCost).toFixed(2)}€`;
                cartSummary.appendChild(totalElem);

                // // Ajouter les actions du panier (avant d'ajouter des boutons)
                // const cartActions = document.createElement('div');
                // cartActions.classList.add('cart-actions');

                // // Ajouter le bouton "Vider le panier"
                // const clearCartBtn = document.createElement('button');
                // clearCartBtn.textContent = 'Vider le panier';
                // clearCartBtn.classList.add('clear-cart-btn');
                // clearCartBtn.addEventListener('click', clearCart);
                // cartActions.appendChild(clearCartBtn);

                
                const checkoutButton = document.createElement('button');
                checkoutButton.classList.add('checkout-btn');
                checkoutButton.textContent = 'Passer à la caisse';
                checkoutButton.onclick = function() {
                    // Rediriger vers la page de commande
                    window.location.href = 'checkout.php';
                };
                cartActions.appendChild(checkoutButton);
                
                const continueShoppingButton = document.createElement('button');
                continueShoppingButton.classList.add('continue-shopping-btn');
                continueShoppingButton.textContent = 'Continuer les achats';
                continueShoppingButton.onclick = function() {
                    // Rediriger vers la page d'accueil
                    window.location.href = 'shop.php';
                };
                cartActions.appendChild(continueShoppingButton);
                
                cartSummary.appendChild(cartActions);

                cartContainer.appendChild(cartSummary);
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    // Charger et afficher le panier
    fetchAndDisplayCart();

    function updateQuantity(productId, newQuantity) {
     // Mettre à jour le panier en localStorage
     let cart = JSON.parse(localStorage.getItem('cart')) || [];
     const productIndex = cart.findIndex(item => item.id === productId);

     if (productIndex !== -1) {
         if (newQuantity > 0) {
             cart[productIndex].quantity = newQuantity;
         } else {
             cart.splice(productIndex, 1);
         }

         localStorage.setItem('cart', JSON.stringify(cart));
     }
    fetch('./update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchAndDisplayCart(); // Rafraîchir l'affichage
            updateCartUI(); // Met à jour le panier (ajout, suppression, quantité)
        } else {
            console.error('Erreur lors de la mise à jour:', data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}
// Fonction pour vider le panier
function clearCart() {
    const userId = "<?php echo $_SESSION['user_id']; ?>"; // Récupère l'ID de l'utilisateur depuis PHP

    // Vider le panier dans la base de données
    fetch(`./clear_cart.php?user_id=${userId}`)
    .then(response => response.json())
    .then(data => { 
        if (data.success) {
            console.log(data);
            localStorage.removeItem('cart'); // Supprimer le panier de localStorage
            updateCartUI(); // Mettre à jour l'interface utilisateur
            alert("Le panier a été vidé.");
        } else {
            console.error('Erreur lors de la suppression du panier dans la base de données:', data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}
// Fonction pour mettre à jour l'UI du panier
function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0); // Calculer le nombre total d'articles
    const cartBadge = document.querySelector('#cart-badge');

    if (cartBadge) {
        cartBadge.textContent = cartCount; // Mettre à jour l'affichage du badge
    }

    // Réafficher les produits dans le panier
    fetchAndDisplayCart(); 
}
// Lier la fonction clearCart au clic du bouton "Vider le panier"
const clearButton = document.querySelector('#clear-cart-btn');
    if (clearButton) {
        clearButton.addEventListener('click', clearCart);
}

    // Met à jour le panier (ajout, suppression, quantité)
    function updateCart() {
        fetch('update_cart.php', { // Ce fichier PHP doit gérer l'update des quantités dans le panier
            method: 'POST',
            body: JSON.stringify(cartItems),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            fetchAndDisplayCart(); // Rafraîchit le panier après mise à jour
        });
    }
});