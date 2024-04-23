<?php
require_once(__DIR__ . '/../database/database_connection.db.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['product_id'])) {
        $db = getDatabaseConnection();
        $product_id = $_POST['product_id'];
        try {
            $stmt = $db->prepare("DELETE FROM PRODUCTS WHERE id = ?");
            $stmt ->execute([$product_id]);

            echo "Product deleted successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
