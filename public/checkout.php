<?php 
include "../config/database.php";
require_once "../functions/functions.php";
$bdd = bdd();
// session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$cart = getCartByUserId($userId);

// Calculer le total du panier
$totalPrice = array_sum(array_column($cart, 'total_price')); // Total des prix
$totalQuantity = array_sum(array_column($cart, 'quantity')); // Total des quantités
$totalItems = count($cart); // Nombre d'articles

// Vérifier si le panier est vide
if (empty($cart)) {
    echo '<p>Votre panier est vide. <a href="shop.php">Continuer vos achats</a>.</p>';
    exit;
}

//Vérifier si le panier est vide
if (empty($cart)) {
    $_SESSION['error_message'] = "Votre panier est vide.";
    header('Location: shop.php');
    exit;
}

// Générer un token CSRF
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer à la caisse</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
    <style>
        #paypal-button-container {
                    display: none;
                }

    </style>
</head>
<body>
    <!-- Header -->
    <?php include '../includes/header.php'; ?>

    <div class="resume-container">
        <div class="commande-resume">
            <h1 class="resume-title">Résumé de votre commande</h1>
            <p class="resume-count-panier">Vous avez <?= count($cart)?> articles (<?= count($cart)?> produits) dans votre panier.</p>
            <p class="resume-add-livraison">Total : <?= number_format($totalPrice, 2)?> € , <span>Frais de livraison : 5€</span></p>
            <p class="resume-totality">Frais Total: <span><?=number_format($totalPrice + 5, 2) ?>€</span></p>
        </div>
        <div class="vertical-cart-resume">
            <h2>Résumé du panier</h2>
            <ul class="cart-item">
                <li>Nombre total d'articles : <?= $totalItems ?></li>
                <li>Quantité totale : <?= $totalQuantity ?></li>        
                <li>Frais Total : <?= number_format($totalPrice, 2) ?> €</li>
                <li class="resume-add-livraison"><span>Frais de livraison : 5€</span></li>
                <li class="resume-totality">Total à payer: <span><?=number_format($totalPrice + 5, 2) ?>€</span></li>
            </ul>
        </div>

    </div>
   
    
    <h2>Liste des articles</h2>
    <div class="array-container">
    <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix unitaire (€)</th>
                    <th>Quantité</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> €</td>
                        <td>
                            <?= $item['quantity'] ?>
                            <!-- <input type="number" name="quantity[<?= $item['cart_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['quantity'] ?>" required> -->
                        </td>
                        <td><?= number_format($item['total_price'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <!-- footer totality -->
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td colspan="1" class="total-price-footer"> <?= number_format($totalPrice, 2)?>€</td>
                    </tr>
                </tfoot>
    </table>

    </div>
   
    <h3>Passer commande</h3>
<div class="checkout-confirme-form">
    <form action="process_checkout.php" method="POST">
        <!-- Champ CSRF pour protéger le formulaire -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

        <!-- Adresse de livraison -->
        <label for="address">Adresse de livraison :</label><br>
        <textarea name="address" id="address" required minlength="10" placeholder="Entrez votre adresse complète"></textarea><br><br>

        <!-- Méthode de paiement -->
        <label for="payment">Méthode de paiement :</label><br>
        <select name="payment_method" id="payment" required>
            <option value="cod">Paiement à la livraison</option>
            <option value="card">Carte bancaire</option>
        </select><br><br>

        <!-- Bouton de confirmation -->
        <button type="submit">Confirmer la commande</button>
    </form>
</div>

<!-- Boutons PayPal -->
<div id="paypal-button-container"></div>

<script src="./assets/script/app.js"></script>
<script src="./assets/script/script.js"></script>
<script src="./assets/script/functions.js"></script>

<!-- Charger le SDK PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id=TON_CLIENT_ID&currency=EUR"></script>
<script>
    // Vérifier si le SDK PayPal est chargé
    if (window.paypal && window.paypal.version >= 7.0) {
        console.log("Le SDK PayPal est chargé correctement!");
    } else {
        console.error("Le SDK PayPal n'est pas chargé correctement!");
    }
    
    // Afficher le bouton PayPal uniquement si la méthode de paiement est carte
    
    document.getElementById('payment').addEventListener('change', function () {
        if (this.value === 'card') {
            document.getElementById('paypal-button-container').style.display = 'block';
        } else {
            document.getElementById('paypal-button-container').style.display = 'none';
        }
    });
    
    // Obtenir l'ID client PayPal
    let clientId = 'TON_CLIENT_ID'; // Remplacer TON_CLIENT_ID par votre ID client PayPal

    // Récupérer le total du panier
    let total = <?= json_encode($totalPrice) ?>; // Injection sécurisée du total du panier

    // Récupérer l'ID utilisateur
    let userId = <?= json_encode($user_id) ?>; // Injection sécurisée de l'ID utilisateur

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= number_format($total, 2, ".", "") ?>'
                    },
                    custom_id: userId // Associe la transaction à l'utilisateur
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert('Transaction effectuée par ' + details.payer.name.given_name);
                window.location.href = "process_checkout.php?paypal=true&user_id=" + userId + "&order_id=" + data.orderID;
            });
        },
        onError: function (err) {
            console.error('Erreur PayPal :', err);
            alert('Une erreur est survenue avec PayPal. Veuillez réessayer.');
        }
    }).render('#paypal-button-container');
</script>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php 
    // Supprimer le panier de la session après la confirmation
    unset($_SESSION['cart']);
?>