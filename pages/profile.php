<?php

require_once(__DIR__ . '/../utils/sessions.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/profile.tpl.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, $session->getId());
drawHeader($session);
drawProfile($db, $user);
drawFooter();