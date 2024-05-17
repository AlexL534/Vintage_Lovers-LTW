<?php

require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ .'/../classes/image.class.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../utils/register_utils.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

$productID = $_POST['productID'];

if (isset($_FILES['image'])){
    $total = count($_FILES['image']['tmp_name']);
    $target_dir = "/../images/";  
    $title = htmlentities($_POST['title']);
    
    if(hasNumbers($title) == 1){
        $session->addMessage('error', 'the title cannot have numbers');
        header("Location: /../pages/add_images.php/?productID=$productID");
        exit();
    }
    
    for($i=0 ; $i < $total ; $i++ ){
        $tmpname = $_FILES["image"]["tmp_name"][$i];

        //create a image representation
        $original = @imagecreatefromjpeg($tmpname);
        if (!$original) $original = @imagecreatefrompng($tmpname);
        if (!$original) $original = @imagecreatefromgif($tmpname);

        if (!$original){
            $session->addMessage('error', 'unknown image format');
            header("Location: /../pages/add_images.php/?productID=$productID");
            exit();
        } 
        $originalFileName = __DIR__ . "/../images/$title" . "$productID" . "$i" .'.jpg';
        $customFileName = "images/$title" . "$productID" . "$i" .'.jpg';

        //inserts the paths into the db
        if(Image::insertImageToProduct($db,$customFileName) === false){
            $session->addMessage('error', 'could not upload the images');
            header("Location: /../pages/add_images.php/?productID=$productID");
            exit();
        }
        $imageId = Image::getLastInsertedImageID($db);
        if($imageID === false){
            $session->addMessage('error', 'could not upload the images');
            header("Location: /../pages/add_images.php/?productID=$productID");
            exit();
        }
        if(Image::insertImageOfProduct($db,$imageId, $productID) === false){
            $session->addMessage('error', 'could not upload the images');
            header("Location: /../pages/add_images.php/?productID=$productID");
            exit();
        }
        if(imagejpeg($original, $originalFileName) === false){
            $session->addMessage('error', 'could not upload the images');
            header("Location: /../pages/add_images.php/?productID=$productID");
            exit();
        }
    }
    header("location: /../pages/seller_add_product.php");
    exit();
}

$session->addMessage('error', 'could not upload the images');
header("Location: /../pages/add_images.php/?productID=$productID");
exit();

