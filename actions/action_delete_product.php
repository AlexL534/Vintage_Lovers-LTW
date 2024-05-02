<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['product_id'])) {
        $db = getDatabaseConnection();
        $productId = $_POST['product_id'];
        
        if (Product::deleteProduct($db, (int)$productId)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Error: Failed to delete product.";
            exit();
        }
    } else {
        echo "Error: Product ID is missing.";
        exit();
    }
} else {
    echo "Error: Invalid request.";
    exit();
}
?>
