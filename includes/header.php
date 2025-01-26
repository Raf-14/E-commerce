
<header>
    <!-- Header de toute l'application -->
    <div class="logo">
        <img src="../public/assets/images/logo1.jpeg" alt="Logo" />
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="../public/index.php">Home</a></li>
            <li><a href="../public/shop.php">Shop</a></li>
            <li><a href="../public/service.php">Service</a></li>
            <li><a href="../public/contact.php">Contact</a></li>
            
            <!-- Afficher "Profile" si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                
                <!-- Exemple de badge panier -->
                <div id="cart-icon">
                    <li><a href="../public/panier.php"><img src="../public/assets/images/panier.jpg" alt="image panier" class="image_panier"></a></li>
                    <!-- Badge de panier -->
                    <div id="cart-badge">0</div>

                </div>

                <li><a href="../public/profile.php">Profile</a></li>
                <li><button type="button" class="disconnected"><a href="../public/logout.php">Se déconnecter</a></button></li>
            <?php else: ?>
                <!-- Afficher "S'inscrire" et "Se connecter" si l'utilisateur n'est pas connecté -->
                <li><a href="../public/register.php">S'inscrire</a></li>
                <li><a href="../public/login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="menu-toggle" id="mobile-menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>
