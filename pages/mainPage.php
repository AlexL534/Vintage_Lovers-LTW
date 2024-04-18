<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../database/product.class.php');
$db = getDatabaseConnection();
drawHeader();

?>
<html>
    <h2>Buy and Sell Pre-loved Clothes</h2>
    <div id="Below_5">
        <h4>Below 5 euros</h4>

        
        <?php 
            
            $products = product::getAllProducts($db);
            foreach($products as $product){ ?>
                <a href=""><?= $product->getName();  ?></a>
                <p><?= $product->getPrice(); ?></p>

        <?php } ?>
            
        
        
    </div>
</html>
<?php 
    drawFooter()
?>