<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/shopping_cart.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();


drawHeader($session);
drawShoppingCart($db, $session);
drawFooter();
?>