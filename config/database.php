<?php

// Function to connect to the database
function bdd() {
    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "e_commerce1";
    
    try {
        // Create a new PDO instance and connect to the database
        $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully.<br>";
        return $conn;
    } catch (PDOException $e) {
        //die("Database connection failed: " . $e->getMessage());
        throw new PDOException($e->getMessage());
        exit();
    }
}

    // Function to get products by category from the database
    // function get_products_by_category($category_id) {
    //     global $bdd;
    //     $stmt = $bdd->prepare("SELECT * FROM products WHERE category_id =?");
    //     $stmt->execute([$category_id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    
?>

