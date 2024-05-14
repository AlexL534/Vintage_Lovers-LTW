<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/profile.tpl.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$session = new Session();

if(!isset($_SESSION['Username'])){
    header('Location: /../pages/main_page.php' );
}

$db = getDatabaseConnection();
$categories = getCategoriesForMenu();
$user = User::getUser($db, $session->getId());
drawHeader($session, $categories);
drawProfile($db, $user);
drawFooter();