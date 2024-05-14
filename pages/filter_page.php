<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/filter_page.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$session = new Session();
$db = getDatabaseConnection();
$categories = getCategoriesForMenu();
$categoryID = intval($_GET['categoryID']);
$search = $_GET['search'];
drawHeader($session,$categories);
drawFilterSection($db,$categoryID, $search);
drawProductSection($db, $categoryID, $search);
drawFooter();

?>