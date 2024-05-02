<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../templates/products.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
$db = getDatabaseConnection();
$session = new Session();
drawHeader($session);
//arranjar id nas classes todas
drawProductInfo($db,intval($_GET['id']));

drawFooter($session);
?>