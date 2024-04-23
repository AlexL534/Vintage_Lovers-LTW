<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../utils/sessions.php');
$db = getDatabaseConnection();
$session = new Session();
drawHeader($session);

?>

    <h2>Buy and Sell Pre-loved Clothes</h2>
    <div id="selectPorducts">
        <h4>Porducts for you</h4>

        
        <?php 
            
            $products = product::getProductByPrice($db,3,100);
            foreach($products as $product){ ?>
                <a href=""><?= $product->getName();  ?></a>
                <p><?= $product->getPrice(); ?></p>

        <?php } ?>
            
        
        
    </div>

<?php 
    drawFooter();
?>