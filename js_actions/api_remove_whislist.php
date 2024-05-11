<?php

require_once(__DIR__ . '/../classes/wishlist.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

$productId = $_GET['productID'];
$userId = $session->getId();

Wishlist::deleteProductInWishlist($db, $userId, $productId);