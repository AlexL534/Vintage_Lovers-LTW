<?php

require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();

$id = 0;
$products = [];

if(isset($_GET['brandID'])){
    $id = $_GET['brandID'];
    $products = Product::getProductByBrand($db, $id);
}

if(isset($_GET['categoryID'])){
    $id = $_GET['categoryID'];
    $products = Product::getProductByCategory($db, $id);
}

if(isset($_GET['colorID'])){
    $id = $_GET['colorID'];
    $products = Product::getProductByColor($db, $id);
}

if(isset($_GET['conditionID'])){
    $id = $_GET['conditionID'];
    $products = Product::getProductByCondition($db, $id);
}

if(isset($_GET['sizesID'])){
    $id = $_GET['sizesID'];
    $products = Product::getProductBySize($db, $id);
}

if($products === false){
    $session->addMessage('error', 'could not get the products from the database');
    header('Location: /../pages/main_page.php');
    exit();
}

$productsForJson= [];

foreach($products as $product){
    $productForJson['id'] = $product->getId();
    $productForJson['price'] = $product->getPrice();
    $productForJson['quantity'] = $product->getQuantity();
    $productForJson['name'] = $product->getName();
    $productForJson['description'] = $product->getDescription();
    $productForJson['owner'] = $product->getOwner();
    $productForJson['category'] = $product->getCategory();
    $productForJson['brand'] = $product->getBrand();
    $productsForJson[] = $productForJson;
}

echo json_encode($productsForJson);