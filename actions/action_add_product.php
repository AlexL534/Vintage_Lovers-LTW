<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: /");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $category = $_POST['category'] ?? '';

    try {
        $db = getDatabaseConnection();
        $userId = $session->getId();
        
        $product = new Product(0, (float)$price, 0, $name, $description, (int)$userId, (int)$category, (int)$brand);
        
        if ($product->save($db)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Failed to add product.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method or form submission.";
}
?>
