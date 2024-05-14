<?php

require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();

$search = $_GET['search'];

$productsDB = Product::searchProducts($db, $search);
$products = [];

foreach($productsDB as $productDB){
    $product = new Product(
        intval($productDB['id']),
        floatval($productDB['price']),
        intval($productDB['quantity']),
        $productDB['name'],
        $productDB['description'],
        intval($productDB['owner']),
        intval($productDB['category']),
        intval($productDB['brand'])
    );
    $products[] = $product;
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