<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/image.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
        echo "Error: Invalid product ID.";
        exit();
    }

    $productId = (int)$_POST['product_id'];

    $db = getDatabaseConnection();

    if (Product::deleteProduct($db, $productId)) {
        
        //deletes all the related information to the product
        if(Size::deleteSizeOfProduct($db, $productId) === false){
            $session->addMessage('error', 'could not delete the product size properly');
            header('Location: /../pages/main_page.php');
        }
        if(Condition::deleteConditionOfProduct($db, $productId) === false){
            $session->addMessage('error', 'could not delete the product condition properly');
            header('Location: /../pages/main_page.php');
        }
        if(Color::deleteColorOfProduct($db, $productId) === false){
            $session->addMessage('error', 'could not delete the product color properly');
            header('Location: /../pages/main_page.php');
        }
        if(SoldProducts::deleteProductSoldProduct($db, $productId) === false){
            $session->addMessage('error', 'could not delete the product from the products sold properly');
            header('Location: /../pages/main_page.php');
        }
        $imagesIDs = Image::getImagesIdFromImageOfProduct($db, $productId);
        if($imagesIDS === false){
            $session->addMessage('error', 'could not get images id properly');
            header('Location: /../pages/main_page.php');
        }
        $imagesPath = Image::getImagesPath($db, $productId);
        if($imagesPath === false){
            $session->addMessage('error', 'could not get the images path properly');
            header('Location: /../pages/main_page.php');
        }
        foreach($imagesIDs as $imageId){
            if(Image::deleteImage($db, $imageId) === false){
                $session->addMessage('error', 'could not delete the images properly');
                header('Location: /../pages/main_page.php');
            }
        }
        foreach($imagesPath as $path){
            unlink(__DIR__ . "/../$path");
        }
        if(Image::deleteImageOfProduct($db, $productId) === false){
            $session->addMessage('error', 'could not delete the images of product properly');
            header('Location: /../pages/main_page.php');
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: Failed to delete product.";
        exit();
    }
} else {
    echo "Error: Invalid request.";
    exit();
}
?>
