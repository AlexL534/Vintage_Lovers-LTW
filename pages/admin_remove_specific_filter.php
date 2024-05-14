<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/filter_type.class.php'); 
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$db = getDatabaseConnection();
$session = new Session();
$admin = USER::getUser($db, $session->getId())->getIsAdmin();
$categories = getCategoriesForMenu();

if (!$session->isLoggedIn() || !$admin) {
    header("Location: /");
    exit;
}

drawHeader($session,$categories);

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $allowedTypes = array('category', 'size', 'condition', 'color', 'brand');
    if (!in_array($type, $allowedTypes)) {
        echo "Invalid filter type specified";
    } else {
        drawRemoveInfoForm($type, $db);
    }
} else {
    echo "No filter type specified";
}

drawFooter();
?>
