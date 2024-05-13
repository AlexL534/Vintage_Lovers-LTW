<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/filter_type.class.php'); 
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$session = new Session();
$admin = USER::getUser($db, $session->getId())->getIsAdmin();
if (!$session->isLoggedIn() || !$admin) {
    header("Location: /");
    exit;
}

drawHeader($session);
drawRemoveFilterTypes();
drawFooter();

?>
