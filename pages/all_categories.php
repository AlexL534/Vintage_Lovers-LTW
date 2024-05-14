<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/header_menu_utils.php');

$session = new Session();
$categories = getCategoriesForMenu();

drawHeader($session,$categories);

?>
