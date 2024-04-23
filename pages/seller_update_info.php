<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');

drawHeader();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    drawUpdateInfoForm($id);
} else {
    echo "No id specified";
}

drawFooter();
?>
