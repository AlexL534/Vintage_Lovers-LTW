<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');

function calculatePrice(array $products) : float{
    //calculates the pproducts total price
    $totalPrice = 0;

    foreach($products as $product){
        $totalPrice += $product->getPrice();
    }

    return $totalPrice;
}