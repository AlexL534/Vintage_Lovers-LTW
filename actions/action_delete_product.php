<?php
require_once(__DIR__ . '/../database/database_connection.db.php');

$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['product_id'])) {
        $db = getDatabaseConnection();
        $product_id = $_POST['product_id'];
        try {
            $stmt = $db->prepare("DELETE FROM PRODUCTS WHERE id = ?");
            $stmt ->execute([$product_id]);

            $message = "Product deleted successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Error: Product ID is missing.";
        exit();
    }
} else {
    $message = "Error: Invalid request.";
    exit();
}
echo $message;
?>
