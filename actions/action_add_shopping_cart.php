<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '../classes/session.class.php');


$db = getDatabaseConnection();

$session = new Session();

$id = intval($_GET['id']);

$stmt=$db->prepare('INSERT INTO SHOPPINGCART VALUES (?,?)');

$stmt->execute(array($session->getId(),$id));

?>