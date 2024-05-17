<?php

require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');

$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    //only continues if everytinh is set
    $userId = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
    if ($userId === false || $userId <= 0) {
        echo "Error: Invalid user ID.";
        exit();
    }

    
    $db = getDatabaseConnection();
    $user = User::getUser($db, $userId);
    if ($user && !$user->getIsAdmin()) {
        if ($user->deleteUser($db)) {
            //deletes the sells that where related to this user
            SoldProducts::deleteProductSoldUser($db,$user->getID());
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
