<?php

require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();

$products = [];

$products = Product::getAllProducts($db);

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