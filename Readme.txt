Création d'un projet E-commerce avec php 


Mercredi lme 15 janvier 2025 
10:52


aide pour le versionning du projet sur git 

initialisation du depôt Git
1.git init
2.Crée un nouveau dépôt sur GitHub (sur la page web de GitHub) et récupère l'URL du dépôt.
3.git remote add origin https://github.com/nom-d'utilisateur/ecommerce-projet.git
4.git add .
5.commit -m "premier commit"
6.git push -u origin master


structure du projet :

1-base de donnée:
Utilisateurs : Pour gérer les clients.
Produits : Pour les articles que tu vends.
Catégories : Pour organiser les produits.
Commandes : Pour suivre les achats des utilisateurs.
Détails de commande : Pour savoir quels produits sont associés à chaque commande.
Panier : Pour stocker temporairement les produits avant achat (optionnel, si tu veux le gérer avant la commande).

Voir le fichier e-commerce.sql pour la configuration et l'installation de la base donnée

2-Création de l'architecture du projet:

ecommerce-project/
├── assets/              # Fichiers CSS, JS, images
├── config/              # Fichiers de configuration (ex : base de données, paramètres)
├── includes/            # Fichiers PHP communs (ex : header, footer, etc.)
├── public/              # Fichiers accessibles au public (ex : index.php, .htaccess)
├── src/                 # Code source (contrôleurs, modèles, etc.)
├── templates/           # Templates HTML ou fichiers view
└── .gitignore           # Fichier pour ignorer certains fichiers/dossiers (ex : .env)
