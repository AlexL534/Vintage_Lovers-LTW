<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/wishlist.class.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../utils/product_utils.php');

function drawWishlist(PDO $db, $session){
    $userID = $session->getId();
    $productsInList = Wishlist::getUserWishlist($db, $userID);
    $products = array();
    foreach($productsInList as $productInList){
        $productDB = Product::getProduct($db, $productInList->getProductID());
        if($productDB !== null){ 
            $products[] = $productDB;
        }
    }
    ?>
    <section id = "whislist">
        <header>
            <h1>Your Whislist</h1>
        </header>
        <?php if(empty($products)){
            ?>
            <article><p>No products in Whislist</p></article>
        <?php } else{
            drawProductsListInWhislist($products);
            ?>
       <?php } ?>
        

    </section>
<?php }

function drawProductsListInWhislist($products){
    ?>
    <article class = "productsTable">
            <table>
                <tr><th>Name</th><th>Price</th><th>Delete</th></tr>
                <?php foreach($products as $product){
                    ?>
                    <tr id = "<?= $product->getId()?>"><td><?= $product->getName() ?></td><td class = "price"><?= $product->getPrice()?></td><td><button class="delButton">Delete</button></td></tr>
                <?php } ?>
            </table>
        </article>
<?php }