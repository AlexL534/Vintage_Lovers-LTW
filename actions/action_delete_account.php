<?php

require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    $db = getDatabaseConnection();
    
    $user = User::getUser($db, $userId);
    if ($user && !$user->getIsAdmin()) {
        if ($user->deleteUser($db)) {
            header("Location: ../pages/admin_manage_user.php");
            exit();
        } else {
            echo "Error: Failed to delete user.";
            exit();
        }
    } else {
        echo "Error: Invalid user or user is an admin.";
        exit();
    }
} else {
    echo "Error: Invalid request.";
    exit();
}

?>
