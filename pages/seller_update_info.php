<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');
require_once(__DIR__ . '/../utils/sessions.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: /");
    exit;
}

drawHeader($session);

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    drawUpdateInfoForm($id);
} else {
    echo "No id specified";
}

drawFooter();
?>
