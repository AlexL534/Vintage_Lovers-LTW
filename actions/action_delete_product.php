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
        Size::deleteSizeOfProduct($db, $productId);
        Condition::deleteConditionOfProduct($db, $productId);
        Color::deleteColorOfProduct($db, $productId);
        SoldProducts::deleteProductSoldProduct($db, $productId);
        $imagesIDs = Image::getImagesIdFromImageOfProduct($db, $productId);
        $imagesPath = Image::getImagesPath($db, $productId);
        foreach($imagesIDs as $imageId){
            Image::deleteImage($db, $imageId);
        }
        foreach($imagesPath as $path){
            unlink(__DIR__ . "/../$path");
        }
        Image::deleteImageOfProduct($db, $productId);

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
