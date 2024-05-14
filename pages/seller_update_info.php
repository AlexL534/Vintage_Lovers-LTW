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

if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
        echo "Invalid id specified";
    } else {
        drawUpdateInfoForm($id);
    }
} else {
    echo "No id specified";
}

drawFooter();
?>
