<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/wishlist.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

if(!isset($_SESSION['Username'])){
    header('Location: ../pages/main_page.php' );
}

drawHeader($session);
drawWishlist($db, $session);
drawFooter();
?>