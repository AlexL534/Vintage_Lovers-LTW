<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../classes/session.class.php');
$session = new Session();
$session->logout();

header('Location: ' . "/../pages/main_page.php");

?>