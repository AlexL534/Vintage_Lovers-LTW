<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');

drawHeader();
drawProductList(false); 
drawFooter(); 

?>