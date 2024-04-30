<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../utils/sessions.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: /");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];

    try {
        $db = getDatabaseConnection();
        $userId = $session->getId();
        $stmt = $db->prepare("INSERT INTO PRODUCTS (name, description, price, owner, brand, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $userId, $brand, $category]);
        echo $name . " was successfully added.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method or form submission.";
}
?>
