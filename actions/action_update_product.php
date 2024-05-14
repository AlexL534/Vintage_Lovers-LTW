<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');

require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    if (!$productId || !$name || !$description || !$price) {
        echo "Error: Invalid input data.";
        exit();
    }

    try {
        $db = getDatabaseConnection();
        
        if (Product::getProduct($db, $productId) !== null) {
            if (Product::updateProduct($db, $productId, $name, $description, $price)) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                echo "Error: Failed to update product.";
                exit();
            }
        } else {
            echo "Error: Product does not exist.";
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
