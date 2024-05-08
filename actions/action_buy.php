<?php

require_once(__DIR__ . '/../classes/shopping_cart.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

$userId = $session->getId();

$userProductsCart = ShoppingCart::getUserShoppingCart($db, $userId);

foreach($userProductsCart as $productCart){
    ShoppingCart::deleteProductInShoppingCart($db, $userId, $productCart->getProductID());
}

header("Location: ../pages/shopping_cart.php");