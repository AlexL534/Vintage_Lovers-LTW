<?php

require_once(__DIR__ . '/../classes/image.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$id = $_GET['id'];

$images = Image::getImagesPath($db,$id);

echo json_encode($images);

