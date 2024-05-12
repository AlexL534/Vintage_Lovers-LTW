<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../templates/products.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');
$db = getDatabaseConnection();
$session = new Session();
$categories = getCategoriesForMenu();
drawHeader($session,$categories);

drawProductInfo($db,intval($_GET['id']), $session);

drawFooter();
?>