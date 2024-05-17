<?php

require_once(__DIR__ . '/../classes/wishlist.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

$productId = $_GET['productID'];
$userId = $session->getId();

if(Wishlist::deleteProductInWishlist($db, $userId, $productId) === false){
    $session->addMessage('error', 'could not delete the product from the wishlist');
    header('Location: /../pages/main_page.php');
    exit();
}