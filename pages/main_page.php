<?php

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../utils/sessions.php');
$db = getDatabaseConnection();
$session = new Session();
drawHeader($session);

?>  <header id= "main_header">
        <img src = "../assets/main_image.jpg" alt = "clothes">
        <h2>Buy and Sell Pre-loved Clothes</h2>
    </header>
    <section id = "main_products">
        <div id="selectProducts">
            <h4>Products for you</h4>

<<<<<<< HEAD
=======
    <h2>Buy and Sell Pre-loved Clothes</h2>
    <div id="selectProducts">
        <h4>Products for you</h4>

        
        <?php 
>>>>>>> 7608cbdd013512caa29fa5ee4eba1d301d08cc8f
            
            <?php 
                
                $products = product::getProductByPrice($db,3,100);
                foreach($products as $product){ ?>
                <article>
                    <a href=""><?= $product->getName();  ?></a>
                    <p><?= $product->getPrice(); ?></p>
                </article>    

            <?php } ?>
                
            
            
        </div>
    </section>

<?php 
    drawFooter();
?>