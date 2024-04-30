<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        try {
            $userId = $_POST['user_id'];

            $stmt = $db->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
            $stmt->execute([$userId]);

            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "User ID is not set.";
    }
} else {
    echo "Form is not submitted.";
}
?>
