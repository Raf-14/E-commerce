<?php
if (session_status() == 'PHP_SESSION_NONE') {
    session_start();
}

require_once '../config/database.php';
require_once '../functions/functions.php';
require_once '../functions/formateDate.php';
$bdd = bdd();


// Appelle e la fontion qui récupère les infos de l'utilisateur connecté

$user = getUserInfo($_SESSION['user_id']);
$results = createOrderHistory();
// Vérifie si l'utilisateur est connecté

if (!$user) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="icon" type="image/png" href="./assets/images/logo.jpeg">
    <link rel="stylesheet" href="./assets/style/style.css">
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
                <!-- modale pour modifier les informations utilisateurs -->
                 <div id="modal-edit-user" class="modal">
                    <div class="modal-content">
                        <span class="close" id="close-modal" class="btn-cancel">&times;</span>
                        <h2>Modifier mes informations</h2>
                        <form id="edit-user-form">
                            <label for="username">Nom :</label>
                            <input type="text" id="username" name="username" value="<?= $user['username']?>" required>
                            <label for="last_name">Prénom:</label>
                            <input type="text" id="last_name" name="last_name" value="<?=$user['last_name'] ?>" required>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?=$user['email'] ?>" required>
                            <label for="phone">Téléphone:</label>
                            <input type="text" id="phone" name="phone" value="<?=$user['phone'] ?>" required>
                            <button type="submit">Sauvegarder</button>
                        </form>
                    </div>
                 </div>
                 <!-- Formulaire pour modifier les informations utilisateurs -->


                <?php    
                    // Affichage des information d'utilisateur connecté
                    echo '
                        <h3>Informations personnelles</h3>
                        <div class="user-info">
                            <p><strong>Nom : </strong>'. $user['username']. '</p>
                            <p><strong>Prénom : </strong>'. $user['last_name']. '</p>
                            <p><strong>Email : </strong>'. $user['email']. '</p>
                            <p><strong>Téléphone : </strong>'. $user['phone']. '</p>
                            <button class="btn-edit" id="open-modal">Modifier</button>
                        </div>';
                ?>
            </section>

            <!-- Historique des commandes -->
            <section id="order-history" class="profile-section">
                <h3>Historique des commandes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Numéro de commande</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Prix total</th>

                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                       foreach ($results as $row) {
                        $formattedDate = formatDate($row['order_date'], $months, $days); // Appeler la fonction ici
                        echo "<tr>
                                <td>{$row['order_number']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['unit_price']} €</td>
                                <td>{$formattedDate}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['total_price']} €</td>
                              </tr>";
                    }
                     ?>
                    </tbody>
                </table>
                        <!-- Ajoutez d'un lien pour voir le reste du tableau -->
                        <a href="#" class="link">Voir plus</a>
            </section>

            <!-- Adresse de livraison -->
            <section id="shipping-address" class="profile-section">
                <?php
                  // Affichage de l'adresse de livraison utilisateur connecté 
                  echo '
                        <h3>Adresse de livraison</h3>
                        <div class="address">
                            <p><strong>Adresse :</strong> '. $user['address']. '</p>
                            <button class="btn-edit">Modifier l\'adresse</button>
                        </div>';
                ?>
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
<!-- Pied de page -->
<?php include '../includes/footer.php'?>

    <script>
        // Exemple de gestion d'édition des informations de profil
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', (e) => {
                const section = e.target.closest('.profile-section');
                const sectionName = section.querySelector('h3').innerText;
                
                // alert(`Vous modifiez la section : ${sectionName}`);
                // Ici, vous pouvez ajouter de la logique pour afficher un formulaire d'édition.
                showModalEditUser();
                document.getElementById('close-modal').addEventListener('click', closeModalEditUser);
                // Exemple de gestion du formulaire de modification des informations utilisateurs
                document.getElementById('open-modal').addEventListener('click', () => {
                const firstName = document.getElementById('first-name').value;
                const lastName = document.getElementById('last-name').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
            
                alert(`Vous modifiez vos informations personnelles : Prénom : ${firstName}, Nom : ${lastName}, Email : ${email}, Téléphone : ${phone}`);
                closeModalEditUser()
        });
            });
        });
         // Fonction pour afficher le modal de modification des informations utilisateurs
        function showModalEditUser() {
            document.getElementById('modal-edit-user').style.display = 'block';
        }

        // Fonction pour fermer le modal de modification des informations utilisateurs
        function closeModalEditUser() {
            document.getElementById('modal-edit-user').style.display = 'none';
        }

    </script> 
        
    <script src="./assets/script/app.js"></script>
    <script src="./assets/script/function.js"></script>
    <script src="./assets/script/script.js"></script>   
</html>
</body>
</html>
