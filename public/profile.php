<?php
session_start();
require_once '../config/database.php';
$bdd = bdd()

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="./assets/style/style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

.profile-container {
    display: flex;
    margin-top: 20px;
}

.profile-sidebar {
    width: 250px;
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.profile-sidebar h2 {
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.profile-sidebar ul {
    list-style: none;
    padding: 0;
}

.profile-sidebar ul li {
    margin: 15px 0;
}

.profile-sidebar ul li a {
    text-decoration: none;
    color: #333;
    font-size: 1rem;
}

.profile-sidebar ul li a:hover {
    color: #007BFF;
}

.profile-content {
    flex: 1;
    padding: 20px;
    background-color: #fff;
}

.profile-section {
    margin-bottom: 30px;
}

.profile-section h3 {
    color: #333;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.user-info, .address, .settings {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

button.btn-edit {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

button.btn-edit:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #f8f8f8;
    color: #333;
}

table td {
    background-color: #f9f9f9;
}

table tr:nth-child(even) {
    background-color: #f1f1f1;
}

    </style>
</head>
<body>

    <!-- En-tête -->
    <?php include '../includes/header.php'?>
    
    <!-- Conteneur du profil -->
     <main>
     <div class="profile-container">
        <div class="profile-sidebar">
            <h2>Mon Profil</h2>
            <ul>
                <li><a href="#personal-info">Informations personnelles</a></li>
                <li><a href="#order-history">Historique des commandes</a></li>
                <li><a href="#shipping-address">Adresse de livraison</a></li>
                <li><a href="#account-settings">Paramètres du compte</a></li>
            </ul>
        </div>

        <div class="profile-content">
            <!-- Informations personnelles -->
            <section id="personal-info" class="profile-section">
                <h3>Informations personnelles</h3>
                <div class="user-info">
                    <p><strong>Nom : </strong>Jean Dupont</p>
                    <p><strong>Email : </strong>jean.dupont@example.com</p>
                    <p><strong>Téléphone : </strong>+33 6 12 34 56 78</p>
                    <button class="btn-edit">Modifier</button>
                </div>
            </section>

            <!-- Historique des commandes -->
            <section id="order-history" class="profile-section">
                <h3>Historique des commandes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Numéro de commande</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>12/01/2025</td>
                            <td>Livrée</td>
                            <td>45,90 €</td>
                        </tr>
                        <tr>
                            <td>#12346</td>
                            <td>05/01/2025</td>
                            <td>En cours</td>
                            <td>29,99 €</td>
                        </tr>
                        <!-- Ajoutez plus de lignes de commande ici -->
                    </tbody>
                </table>
            </section>

            <!-- Adresse de livraison -->
            <section id="shipping-address" class="profile-section">
                <h3>Adresse de livraison</h3>
                <div class="address">
                    <p><strong>Adresse :</strong> 123 Rue de Paris, 75001 Paris, France</p>
                    <button class="btn-edit">Modifier l'adresse</button>
                </div>
            </section>

            <!-- Paramètres du compte -->
            <section id="account-settings" class="profile-section">
                <h3>Paramètres du compte</h3>
                <div class="settings">
                    <p><strong>Mot de passe :</strong> ************</p>
                    <button class="btn-edit">Modifier le mot de passe</button>
                    <p><strong>Préférences de communication :</strong> Email, SMS</p>
                    <button class="btn-edit">Modifier les préférences</button>
                </div>
            </section>
        </div>
    </div>

     </main>
    <script>
        // Exemple de gestion d'édition des informations de profil
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', (e) => {
        const section = e.target.closest('.profile-section');
        const sectionName = section.querySelector('h3').innerText;
        
        alert(`Vous modifiez la section : ${sectionName}`);
        // Ici, vous pouvez ajouter de la logique pour afficher un formulaire d'édition.
    });
});

    </script> <!-- Fichier JavaScript à inclure -->
 <script src="./assets/script/app.js"></script>
    <!-- footer  -->
     <?php include '../includes/footer.php';?>
</html>
</body>
</html>
