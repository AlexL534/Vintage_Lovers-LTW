<?php

require_once(__DIR__ . '/../classes/shopping_cart.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

$userId = $session->getId();

$userProductsCart = ShoppingCart::getUserShoppingCart($db, $userId);

foreach($userProductsCart as $productCart){
    //delete every product from the shopping cart of the user
    if(ShoppingCart::deleteProductInShoppingCart($db, $userId, $productCart->getProductID()) === false){
        $session->addMessage('error', 'could not delete the product from the shopping cart');
        header('Location: /../pages/main_page.php');
        exit();
    }
}

foreach($userProductsCart as $productCart){
    //adds the products that where on the shopping cart to the sold products
    $product = Product::getProduct($db, $productCart->getProductID());
    if($product === null){
        continue;
    }
    else if($product === false){
        $session->addMessage('error', 'could not add the product to the sold products');
        header('Location: /../pages/main_page.php');
        exit();
    }
    
    if(SoldProducts::addProductSold($db, $userId, $product->getOwner(), $product->getId(), $_POST['address']) === false){
        $session->addMessage('error', 'could not add the product to the sold products');
        header('Location: /../pages/main_page.php');
        exit();
    }
}



header("Location: /../pages/shopping_cart.php");