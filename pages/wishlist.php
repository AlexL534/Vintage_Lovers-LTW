<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/wishlist.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$db = getDatabaseConnection();
$session = new Session();
$categories = getCategoriesForMenu();

if(!isset($_SESSION['Username'])){
    header('Location: ../pages/main_page.php' );
}

drawHeader($session,$categories);
drawWishlist($db, $session);
drawFooter();
?>