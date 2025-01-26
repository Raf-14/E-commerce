--phpMyAdmin SQL Dump
--version
--https://www.phpmyadmin.net/
--
--hôte: 127.0.0.1:
--généré le : mer.15 jan. 2025 à 10:55
--Version du serveur :
--Version de PHP : 

-- Base de données : `E-commerce`
--

-- --------------------------------------------------------

--
--
--creation d'un table si elle n'existe pas

CREATE DATABASE IF NOT EXISTS E-commerce;

USE E-commerce;

-- --------------------------------------------------------

--creation d'une table si elle n'existe pas dans la bdd

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock` INT NOT NULL,
  `category_id` INT,
  `image_url` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (category_id) REFERENCES categories(id)
)

-- Création de la table categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

--insertion des categorie des produits
INSERT INTO categories (name, description) VALUES 
('Fruits', 'Fruits frais et délicieux, parfaits pour une alimentation saine.'),
('Légumes', 'Légumes frais et nutritifs pour vos plats.'),
('Produits frais', 'Produits frais tels que lait, yaourt, fromage, etc.');


-- Création de la table users (utilisateurs)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    last_name VARCHAR(100),
    address VARCHAR(255),
    phone VARCHAR(15),
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table products (produits)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

--insertion des produits selon leurs catégories
-- Produits de la catégorie Fruits
-- INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES
-- ('Ananas', 'Ananas fraîche et sucrée', 1.99, 50, 1, 'assets/images/fruits/ananas.jpeg'),
-- ('Banane', 'Banane mûre et délicieuse', 1.49, 30, 1, './assets/images/fruits/bananas.jpeg');

-- -- Produits de la catégorie Légumes
-- INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES
-- ('Carotte', 'Carotte fraîche et croquante', 0.99, 100, 2, 'images/carotte.jpg'),
-- ('Brocoli', 'Brocoli riche en vitamines', 2.50, 60, 2, 'images/brocoli.jpg');

-- -- Produits de la catégorie Produits frais
-- INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES
-- ('Lait', 'Lait entier frais', 1.20, 200, 3, 'images/lait.jpg'),
-- ('Yaourt nature', 'Yaourt nature crémeux', 0.80, 150, 3, 'images/yaourt.jpg');


-- Création de la table orders (commandes)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'shipped', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table order_details (détails de commande)
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Création de la table cart (panier)
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

--Création de la table mail

CREATE TABLE emails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)


-- Création de la table reviews (avis)
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)



--modification d'une table

-- ALTER TABLE orders ADD COLUMN user_email VARCHAR(255) NOT NULL AFTER user_id;
--ALTER TABLE orders ADD CONSTRAINT fk_orders_users_email FOREIGN KEY (user_email) REFERENCES users(email);

--modification d'une table précise par son id
--UPDATE `products` SET `image_url` = 'assets/images/aliments/Chili_Peppers.jpeg' WHERE `products`.`id` = 17;

--Destruction des tables

-- DROP TABLE reviews;
-- DROP TABLE cart;
-- DROP TABLE order_details;
-- DROP TABLE orders;
-- DROP TABLE products;
-- DROP TABLE users;
-- DROP TABLE categories;

