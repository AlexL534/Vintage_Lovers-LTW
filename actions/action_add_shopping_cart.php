<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/shopping_cart.class.php');


$db = getDatabaseConnection();

$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

$id = intval($_POST['productID']);

if(!ShoppingCart::isProductInShoppingCart($db, $session->getId(), $id)){ 
    //inserts the products into the shopping cart only if it hasn't there yet
    if(ShoppingCart::insertProductInShoppingCart($db, $session->getId(), $id) === false){
        $session->addMessage('error', 'could not insert product into the shopping cart');
        header('Location: /../pages/main_page.php');
        exit();
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");

?>