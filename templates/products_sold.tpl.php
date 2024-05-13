<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/sold_products.class.php');
require_once(__DIR__ . '/../classes/user.class.php');

function drawSoldProductsTable(PDO $db, int $sellerID){
    //draws the table with seller's the sold products
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
                    <tr><td><a href = "/../pages/products.php/?id=<?=$product->getId()?>"><?= $product->getName() ?></a></td><td><?= $buyer->getName()?></td><td><button type="button" onclick = "window.location='/../pages/print.php/?id=<?=$productSold->getSellID()?>';">Print</button></td></tr>
                <?php } ?>
            </table>
       <?php } 
    ?>
        </article>
    </section>

<?php }

function drawPrintSoldProduct(PDO $db, int $soldProductID){
    //draws the shipping form
    $soldProduct = SoldProducts::getProductSold($db, $soldProductID);
    $product = Product::getProduct($db, $soldProduct->getProductID());
    $receiver = User::getUser($db, $soldProduct->getBuyerID());
    ?>
    <section id="print">
        <header>
            <h1>Shipping Form</h1>
        </header>
        <h2>Product</h2>
        <ul>
            <li><p>Id: <?=$product->getId()?></p></li>
            <li><p>Name: <?=$product->getName()?></p></li>
            <li><p>Price: <?=$product->getPrice()?>€</p></li>
        </ul>
        <h2>Receiver</h2>
        <ul>
            <li><p>Name: <?=$receiver->getName()?></p></li>
            <li><p>Address: <?=$soldProduct->getAddress()?></p></li>
        </ul>
    </section>
<?php }