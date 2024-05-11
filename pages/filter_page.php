<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/filter_page.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader($session);
drawFilterSection($db);
drawProductSection($db);
drawFooter();

?>