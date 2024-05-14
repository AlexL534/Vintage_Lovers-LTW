<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if (!$session->isLoggedIn()) {
    header("Location: /");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    //continues only if everything is set
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $category = $_POST['category'] ?? '';
    $color = $_POST['color'] ?? '';
    $size = $_POST['size'] ?? '';
    $condition = $_POST['condition'] ?? '';

    try {
        $db = getDatabaseConnection();
        $userId = $session->getId();
        
        $product = new Product(0, (float)$price, 0, $name, $description, (int)$userId, (int)$category, (int)$brand);
        
        if ($product->save($db)) {

            //get the product new id from the db
            $id = Product::getLastInsertedID($db);

            if($id === false){
                echo "error";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }


            Size::insertSizeOfProduct($db, $id, $size);
            Color::insertColorOfProduct($db, $id, $color);
            Condition::insertConditionOfProduct($db, $id, $condition);
            
            header("Location: " . "/../pages/add_images.php/?productID=$id");
        } else {
            echo "Failed to add product.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method or form submission.";
}
?>
