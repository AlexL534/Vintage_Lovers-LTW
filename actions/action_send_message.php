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


UserMessage::insertMessage($sid,$rid,$pid,$text,$db);

header("Location: ../pages/messages_page.php?sid=$sid&rid=$rid&pid=$pid");
exit();
?>