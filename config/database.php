<?php

// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$db_name = "e_commerce";

try {
    // Crée une nouvelle instance PDO et se connecte à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// // Get data from JSON file
// $json_data = file_get_contents('../produits.json');

// // Decode the JSON data into an associative array
// $products = json_decode($json_data, true);

// // Prepare the SQL query for inserting products
// $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, category_id, image_url) 
//                         VALUES (:name, :description, :price, :stock, :category_id, :image_url)");

// foreach ($products as $product) {
//     // Bind parameters
//     $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':description', $description);
//     $stmt->bindParam(':price', $price);
//     $stmt->bindParam(':stock', $stock);
//     $stmt->bindParam(':category_id', $category_id);
//     $stmt->bindParam(':image_url', $image_url);
    
//     // Assign values to the parameters
//     $name = $product['name'];
//     $description = $product['description'];
//     $price = $product['price'];
//     $stock = $product['stock'];
//     $category_id = $product['category_id'];
//     $image_url = $product['image_url'];

//     // Execute the statement
//     $stmt->execute();
// }

// // Success message after inserting all products
// echo "All products have been successfully inserted.";

?>
