<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../templates/messages.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();
$db = getDatabaseConnection();


if(!$session->isLoggedIn()){
    header('Location: ../pages/main_page.php' );
}

$sid = intval($_GET['senderID']);
$rid = intval($_GET['receiverID']);
$pid = intval($_GET['productID']);


if(($session->getId() !== $sid) && ($session->getId() !== $rid)){
    header('Location: ../pages/main_page.php' ); 
}

drawHeader($session);
drawMessages($db,$rid,$sid,$pid,$session);
drawProductInfo($pid,$db);
drawMessageForm($sid,$rid,$pid);
drawFooter();



?>