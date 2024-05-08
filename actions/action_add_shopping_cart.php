<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/shopping_cart.class.php');


$db = getDatabaseConnection();

$session = new Session();

$id = intval($_POST['productID']);

if(!ShoppingCart::isProductInShoppingCart($db, $session->getId(), $id)){
    ShoppingCart::insertProductInShoppingCart($db, $session->getId(), $id);
}

header("Location: {$_SERVER['HTTP_REFERER']}");

?>