<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../templates/messages.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$session = new Session();
$db = getDatabaseConnection();
$categories = getCategoriesForMenu();

if(!$session->isLoggedIn()){
    header('Location: index.php' );
}
drawHeader($session,$categories);
drawInbox($session,$db);
drawFooter();

?>