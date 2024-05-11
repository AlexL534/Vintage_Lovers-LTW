<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/wishlist.class.php');


$db = getDatabaseConnection();

$session = new Session();

$id = intval($_POST['productID']);

if(!Wishlist::isProductInWishlist($db, $session->getId(), $id)){
    Wishlist::insertProductInWishlist($db, $session->getId(), $id);
}

header("Location: {$_SERVER['HTTP_REFERER']}");

?>