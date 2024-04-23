<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/sessions.php');
require_once(__DIR__ . '/../templates/authentication.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();

drawHeader($session);
drawSignup($session);
drawFooter();

?>
