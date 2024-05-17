<?php

require_once(__DIR__ . '/../classes/image.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

$db = getDatabaseConnection();
$id = $_GET['id'];

$images = Image::getImagesPath($db,$id);

if($images === false){
    $session->addMessage('error', 'error while loading the images');
    header('Location: /../pages/main_page.php');
    exit();
}

echo json_encode($images);

