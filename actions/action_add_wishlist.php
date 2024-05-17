<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/wishlist.class.php');


$db = getDatabaseConnection();

$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

$id = intval($_POST['productID']);

if(!Wishlist::isProductInWishlist($db, $session->getId(), $id)){
    if(Wishlist::insertProductInWishlist($db, $session->getId(), $id) === false){
        $session->addMessage('error', 'could not insert the product into the wishlist');
        header('Location: /../pages/main_page.php');
        exit();
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");

?>