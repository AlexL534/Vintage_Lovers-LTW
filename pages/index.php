<?php

require_once(__DIR__ . '/../utils/sessions.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/authentication.tpl.php');

$session = new Session();

drawHeader($session);
drawFooter();

?>