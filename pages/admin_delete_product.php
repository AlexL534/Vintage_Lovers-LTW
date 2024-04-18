<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');

drawHeader();
drawProductList(true); //according to figma, it should have product image, but database still doesn't support that
drawFooter(); //also, didn't implement check info button (don't know what info should be displayed) nor delete

?>