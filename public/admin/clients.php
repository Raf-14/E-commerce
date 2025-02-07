<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    <main>
        <!-- Liste des clients avec des inforations de base -->
         <div class="clients-table">
            <h2>Liste des clients</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>0612345678</td>
                        <td>john.doe@example.com</td>
                        <td>123 Main St</td>
                        <td>2020-01-01</td>
    
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>0698765432</td>
                        <td>jane.smith@example.com</td>
                        <td>456 Elm St</td>
                        <td>2020-02-01</td>
    
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Bob</td>
                        <td>Johnson</td>
                        <td>0634567890</td>
                        <td>bob.johnson@example.com</td>
                        <td>789 Oak St</td>
                        <td>2020-03-01</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Alice</td>
                        <td>Williams</td>
                        <td>0656789012</td>
                        <td>alice.williams@example.com</td>
                        <td>987 Pine St</td>
                        <td>2020-04-01</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>David</td>
                        <td>Brown</td>
                        <td>0678901234</td>
                        <td>david.brown@example.com</td>
                        <td>321 Maple St</td>
                        <td>2020-05-01</td>
                    </tr>
                    </tr>
                </tbody>        
            </table>
         </div>
         <!-- Historique de tâche pour chacque client -->
          <div class="task-history">
            <h2>Historique de tâches pour le client 1</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tâche</th>
                        <th>Date</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Réserver un tableau</td>
                        <td>2020-01-01</td>
                        <td>En cours</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Prendre rendez-vous avec le client</td>
                        <td>2020-02-01</td>
                        <td>Terminé</td>
                    </tr>
                </tbody>
                
            </table>
            </div>

            <!-- Option pour contacter le client -->
             <div class="contact-client">
                <h2>Contacter le client </h2>
                <form action="">
                    <label for="name">Nom:</label><br>
                    <input type="text" id="name" name="name"><br>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email"><br>
                    <label for="message">Message:</label><br>
                    <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
                    <input type="submit" value="Envoyer">
                </form>
            </div>
   
    </main>
</body>
</html>