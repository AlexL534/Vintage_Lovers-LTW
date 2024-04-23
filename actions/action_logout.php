<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../utils/sessions.php');
$session = new Session();
$session->logout();

header('Location: ' . "../pages/main_page.php");

?>