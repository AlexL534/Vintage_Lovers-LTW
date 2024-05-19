<?php

declare(strict_types = 1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/message.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();
$db = getDatabaseConnection();
$sid = intval($_POST['senderID']);
$rid = intval($_POST['receiverID']);
$pid = intval($_POST['productID']);
$text = $_POST['messageText'];

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}


if(UserMessage::insertMessage($sid,$rid,$pid,$text,$db) === false){
    $session->addMessage('error', 'could not send the message. Database error');
    header('Location: /../pages/main_page.php');
    exit();
}


?>