<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

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
