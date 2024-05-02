<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
        $userId = (int)$_POST['user_id'];
        $db = getDatabaseConnection();
        
        if (User::updateAdminStatus($db, (int)$userId)) {
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            echo "Error: Failed to update admin status.";
            exit();
        }
    } else {
        echo "Error: Invalid user ID.";
    }
} else {
    echo "Error: Form is not submitted.";
}
?>
