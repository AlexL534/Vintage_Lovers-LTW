<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');

$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        
        if (User::updateAdminStatus($db, (int)$userId)) {
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            echo "Error: Failed to update admin status.";
            exit();
        }
    } else {
        echo "User ID is not set.";
    }
} else {
    echo "Form is not submitted.";
}
?>
