
    document.addEventListener('DOMContentLoaded', function() {
    const addToCartButton = document.querySelector('#add-to-cart-btn');
    const quantityInput = document.querySelector('#quantity');
    const productId = document.querySelector('#productId').value; // Récupérer l'ID du produit sélectionné
    const productPrice = document.querySelector('#productPrice').value; // Récupérer le prix du produit
    const productName =  document.querySelector('#productName').value;
    const productImage =   document.querySelector('#pruductImage').value;

    
    // Récupère le panier actuel depuis localStorage, ou un tableau vide s'il n'existe pas
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Fonction pour ajouter un produit au panier
    addToCartButton.addEventListener('click', function() {
        const quantity = parseInt(quantityInput.value);
        if (quantity < 1) {
            alert("Veuillez sélectionner une quantité valide.");
            return;
        }

        // Récupérer les informations du produit depuis les champs cachés ou d'autres sources
        const product = {
            id: productId,
            name:productName,
            image: productImage,
            price: productPrice,
            quantity: quantity
        };

        // Récupère le panier actuel depuis localStorage, ou un tableau vide s'il n'existe pas
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Vérifie si le produit est déjà dans le panier
        const existingProductIndex = cart.findIndex(item => item.id === product.id);

        if (existingProductIndex !== -1) {
            // Si le produit existe déjà, on met à jour la quantité
            cart[existingProductIndex].quantity += quantity;
        } else {
            // Si le produit n'est pas dans le panier, on l'ajoute
            cart.push(product);
        }

        // Sauvegarde le panier mis à jour dans localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Affiche un message de confirmation
        alert("Produit ajouté au panier !");

        // Met à jour l'affichage du panier
        updateCartUI();
    });

    // Fonction pour mettre à jour l'UI du panier
    function updateCartUI() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = cart.reduce((total, item) => total + item.quantity, 0); // Calculer le nombre total d'articles
        const cartBadge = document.querySelector('#cart-badge');

        if (cartBadge) {
            cartBadge.textContent = cartCount; // Mettre à jour l'affichage du badge
        }
    }

    // Mise à jour du badge du panier dès le chargement de la page
    updateCartUI();
});




          document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le panier depuis localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Si le panier est vide, afficher un message approprié
    if (cart.length === 0) {
        document.querySelector('.cart').innerHTML = '<p>Votre panier est vide.</p>';
        return;
    }

    // Sélectionner l'élément contenant le panier
    const cartContainer = document.querySelector('.cart');

    // Effacer les anciens éléments (au cas où)
    cartContainer.innerHTML = '';

    // Ajouter le titre du panier
    const title = document.createElement('h1');
    title.textContent = "Mon Panier";
    cartContainer.appendChild(title);

    // Calculer le sous-total et ajouter les produits au panier
    let subtotal = 0;
    cart.forEach(item => {
        const productTotal = item.price * item.quantity;
        subtotal += productTotal;

        // Créer un élément pour chaque produit
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        
        // Ajouter l'image du produit
        const img = document.createElement('img');
        img.src = item.image; // Récupère l'URL de l'image depuis le panier
        img.alt = item.name;
        img.classList.add('product-image');
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
        
        // Quantité et boutons
        const quantityContainer = document.createElement('div');
        quantityContainer.classList.add('quantity');
        
        const decreaseButton = document.createElement('button');
        decreaseButton.classList.add('decrease');
        decreaseButton.textContent = '-';
        quantityContainer.appendChild(decreaseButton);
        
        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.value = item.quantity;
        quantityInput.classList.add('quantity-input');
        quantityInput.min = 1;
        quantityContainer.appendChild(quantityInput);
        
        const increaseButton = document.createElement('button');
        increaseButton.classList.add('increase');
        increaseButton.textContent = '+';
        quantityContainer.appendChild(increaseButton);
        
        itemDetails.appendChild(quantityContainer);
        
        const itemTotal = document.createElement('p');
        itemTotal.classList.add('item-total');
        itemTotal.textContent = `Total : ${productTotal}€`;
        itemDetails.appendChild(itemTotal);
        
        cartItem.appendChild(itemDetails);
        
        // Bouton de suppression
        const removeButton = document.createElement('button');
        removeButton.classList.add('remove-item');
        removeButton.textContent = 'Supprimer';
        cartItem.appendChild(removeButton);
        
        cartContainer.appendChild(cartItem);

        // Gérer les événements sur les boutons de quantité
        decreaseButton.addEventListener('click', function() {
            if (item.quantity > 1) {
                item.quantity--;
                quantityInput.value = item.quantity;
                itemTotal.textContent = `Total : ${item.price * item.quantity}€`;
                updateCart(cart);
            }
        });

        increaseButton.addEventListener('click', function() {
            item.quantity++;
            quantityInput.value = item.quantity;
            itemTotal.textContent = `Total : ${item.price * item.quantity}€`;
            updateCart(cart);
        });

        // Gérer la suppression du produit
        removeButton.addEventListener('click', function() {
            const index = cart.findIndex(p => p.id === item.id);
            if (index !== -1) {
                cart.splice(index, 1);
                updateCart(cart);
            }
        });
    });

    // Ajouter les informations de résumé du panier (Sous-total, Frais de livraison, Total)
    const cartSummary = document.createElement('div');
    cartSummary.classList.add('cart-summary');
    
    const subtotalElem = document.createElement('p');
    subtotalElem.classList.add('subtotal');
    subtotalElem.textContent = `Sous-total : ${(subtotal).toFixed(2)}€`;
    cartSummary.appendChild(subtotalElem);

    const shippingElem = document.createElement('p');
    shippingElem.classList.add('shipping');
    const shippingCost = 5; // Exemple de frais de livraison
    shippingElem.textContent = `Frais de livraison : ${(shippingCost).toFixed(2)}€`;
    cartSummary.appendChild(shippingElem);

    const totalElem = document.createElement('p');
    totalElem.classList.add('total');
    totalElem.textContent = `Total : ${(subtotal + shippingCost).toFixed(2)}€`;
    cartSummary.appendChild(totalElem);

    // Ajouter les actions du panier
    const cartActions = document.createElement('div');
    cartActions.classList.add('cart-actions');
    
    const checkoutButton = document.createElement('button');
    checkoutButton.classList.add('checkout-btn');
    checkoutButton.textContent = 'Passer à la caisse';
    cartActions.appendChild(checkoutButton);
    
    const continueShoppingButton = document.createElement('button');
    continueShoppingButton.classList.add('continue-shopping-btn');
    continueShoppingButton.textContent = 'Continuer les achats';
    cartActions.appendChild(continueShoppingButton);
    
    cartSummary.appendChild(cartActions);

    cartContainer.appendChild(cartSummary);
});

// Met à jour le panier dans localStorage et met à jour l'interface
function updateCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload(); // Recharger la page pour mettre à jour le panier (en option)
}

    
    

