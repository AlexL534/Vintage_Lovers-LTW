<?php

require_once(__DIR__ . '/../classes/shopping_cart.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

$userId = $session->getId();

$userProductsCart = ShoppingCart::getUserShoppingCart($db, $userId);

foreach($userProductsCart as $productCart){
    ShoppingCart::deleteProductInShoppingCart($db, $userId, $productCart->getProductID());
}

foreach($userProductsCart as $productCart){
    $product = Product::getProduct($db, $productCart->getProductID());
    SoldProducts::addProductSold($db, $userId, $product->getOwner(), $product->getId(), $_POST['address']);
}



header("Location: /../pages/shopping_cart.php");