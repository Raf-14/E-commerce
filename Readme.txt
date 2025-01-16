Création d'un projet E-commerce avec php 


Mercredi lme 15 janvier 2025 
10:52

architecture d'application E-commerce 
onglet:
Home, Shop, Panier, service, contact, inscription, connection
affichage 
HomePage : iamge en arriére plan , petite intro du schop , button(Shop)
Shop: affichage des produits disponible de la boutique
Panier: affichage de tous les produits selectionné par l'utilisateur pour l'achat final
service: explication des service de la boutique et de l'application
contact: permet à l'utilisateur de contacter les dirigeants de la boutique via un formulaire de contact
inscription: permet à l'utilisateur de s'inscrire pour avoir les priviliéges d'achat ect ....
connection: permet à l'utilisateur de se connecter au site .

aide pour le versionning du projet sur git 

initialisation du depôt Git
1.git init
2.Crée un nouveau dépôt sur GitHub (sur la page web de GitHub) et récupère l'URL du dépôt.
3.git remote add origin https://github.com/Raf-14/E-commerce 
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
