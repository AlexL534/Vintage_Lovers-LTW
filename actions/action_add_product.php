<?php
require_once(__DIR__ . '/../database/database_connection.db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    try {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("INSERT INTO PRODUCTS (name, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $price]);
        echo $name . " was successfully added.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method or form submission.";
}
?>
