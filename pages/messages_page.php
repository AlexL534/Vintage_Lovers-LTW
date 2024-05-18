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
    header('Location: ../pages/main_page.php' );
}

$sid = intval($_GET['sid']);
$rid = intval($_GET['rid']);
$pid = intval($_GET['pid']);


if($session->getId() != $sid && $session->getId() != $rid){
    header('Location: ../pages/main_page.php' ); 
}

if($sid == $rid){
    header('Location: ../pages/main_page.php' ); 
}



drawHeader($session,$categories);
drawMessages($db,$pid,$session,$rid);
drawProductInfo($pid,$db);
drawMessageForm($sid,$rid,$pid);
drawFooter();



?>