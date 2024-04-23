<?php
require_once(__DIR__ . '/../database/database_connection.db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $product_id = $_POST['product_id']; // Retrieve the product ID from the hidden input field
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    try {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("UPDATE PRODUCTS SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $product_id]);
        echo $name . " was successfully updated.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method or form submission.";
}
?>
