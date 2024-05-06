<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/profile.tpl.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$session = new Session();

if(!isset($_SESSION['Username'])){
    header('Location: index.php' );
}

$db = getDatabaseConnection();

$user = User::getUser($db, $session->getId());
drawHeader($session);
drawEditProfile($db, $user, $session);
drawFooter();