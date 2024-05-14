<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$session = new Session();
$categories = getCategoriesForMenu();

if (!$session->isLoggedIn()) {
    header("Location: /");
    exit;
}

drawHeader($session,$categories);
drawProductList(false, $session); 
drawFooter(); 

?>