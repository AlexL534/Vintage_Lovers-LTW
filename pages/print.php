<?php

require_once(__DIR__ . '/../templates/products_sold.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();
$categories = getCategoriesForMenu();

$buyerID = $_GET['buyerID'];
$productID = $_GET['productID'];
drawHeader($session,$categories);
drawPrintSoldProduct( $db,  $buyerID , $productID);
drawFooter();