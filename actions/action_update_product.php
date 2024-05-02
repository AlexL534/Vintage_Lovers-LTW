<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    try {
        $db = getDatabaseConnection();
        
        if (Product::updateProduct($db, (int)$productId, $name, $description, (float)$price)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Error: Failed to update product.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method or form submission.";
    exit();
}
?>
