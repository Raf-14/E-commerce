<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    
    <main>
        <div class="orders-story">
            <!-- tableau de commandes avec des colonnes pour l'ID de la commande, le client, le status -->
                <table>
                    <thead>
                        <tr>
                            <th>ID de commande</th>
                            <th>Client</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ajoutez des lignes pour chaque commande avec les données correspondantes -->
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>En attente</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>En cours de livraison</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bob Johnson</td>
                            <td>Livré</td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Ajoutez un lien pour voir le reste du tableau -->
                 <a href="#" class="link">Voir plus</a>
        </div>
        
        <!-- Détails de la commande pour chacque entrée -->
         <div id="order-details" class="order-details">
             <!-- Affichage des détails de la commande (ID, client, date, etc.) -->
             <h3>Détails de la commande</h3>
             <div class="order-info">
                 <p>ID de commande : 1</p>
                 <p>Client : John Doe</p>
                 <p>Date : 12/03/2021</p>
                 <!-- Ajoutez des informations supplémentaires sur la commande -->
             </div>
             
             <!-- Affichage des produits commandés -->
             <h3>Produits commandés</h3>
             <table>
                 <thead>
                     <tr>
                         <th>Produit</th>
                         <th>Quantité</th>
                         <th>Prix unitaire</th>
                         <th>Total</th>
                     </tr>
                 </thead>
                 <tbody>
                     <!-- Ajoutez des lignes pour chaque produit avec les données correspondantes -->
                     <tr>
                         <td>Product 1</td>
                         <td>2</td>
                         <td>$10.00</td>
                         <td>$20.00</td>
                     </tr>
                     <tr>
                         <td>Product 2</td>
                         <td>1</td>
                         <td>$5.00</td>
                         <td>$5.00</td>
                     </tr>
                 </tbody>
                 <tfoot>
                     <tr>
                         <td colspan="3">Total</td>
                         <td>$25.00</td>
                     </tr>
                 </tfoot>
                 </table>
                 <!-- Ajoutez un lien pour voir le reste du tableau -->
                  <a href="#" class="link">Voir plus</a>
         </div>
         

    </main>
    
   
</body>
</html>