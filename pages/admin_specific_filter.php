<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');

drawHeader();

if(isset($_GET['type'])) {
    $type = $_GET['type'];
    drawAddInfoForm($type);
} else {
    echo "No filter type specified";
}

drawFooter();
?>
