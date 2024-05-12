<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$db = getDatabaseConnection();
$session = new Session();
$admin = User::getUser($db, $session->getId())->getIsAdmin();
$categories = getCategoriesForMenu();

if (!$session->isLoggedIn() || !$admin) {
    header("Location: /"); 
    exit; 
}

drawHeader($session,$categories);
drawProductList(true, $session); //according to figma, it should have product image, but database still doesn't support that
drawFooter(); //also, didn't implement check info button (don't know what info should be displayed)

?>
