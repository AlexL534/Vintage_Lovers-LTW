<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');
require_once(__DIR__ . '/../classes/user.class.php');

function drawSoldProductsTable(PDO $db, int $sellerID){

    $productsSold = SoldProducts::getProductsSoldSeller($db, $sellerID);
    ?>

    <section id = "productsSold">
    <header>
        <h1>Sold Products</h1>
    </header>

    <article class = "productsTable">
    <?php 
        if(empty($productsSold)){
            ?> 
            <p>No products sold</p>
            <?php
        } else{
            ?>
            <table>
                <tr><th>Product Name</th><th>Buyer</th><th>Print</th></tr>
                <?php foreach($productsSold as $productSold){
                    $buyer = User::getUser($db, $productSold->getBuyerID());
                    $product = Product::getProduct($db, $productSold->getProductID());
                    ?>
                    <tr><td><a href = "/../pages/products.php/?id=<?=$product->getId()?>"><?= $product->getName() ?></a></td><td><?= $buyer->getName()?></td><td><button>Print</button></td></tr>
                <?php } ?>
            </table>
       <?php } 
    ?>
        </article>
    </section>

<?php }