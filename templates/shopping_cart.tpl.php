<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/shopping_cart.class.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../utils/product_utils.php');

function drawShoppingCart(PDO $db, $session){
    $userID = $session->getId();
    $productsInCart = ShoppingCart::getUserShoppingCart($db, $userID);
    $products = array();
    foreach($productsInCart as $productInCart){
        $productDB = Product::getProduct($db, $productInCart->getProductID());
        if($productDB !== null){ 
            $products[] = $productDB;
        }
    }
    ?>
    <script src = "../javascript/shoppingCart.js" defer></script>
    <section id = "shoppingCart">
        <header>
            <h1>Your Cart</h1>
        </header>
        <?php if(empty($products)){
            ?>
            <article><p>No products in cart</p></article>
        <?php } else{
            drawProductsListInCart($products);
        } ?>
        <div id = "buyButton">
            <a href = "">BUY</a>
        </div>

    </section>
<?php }

function drawProductsListInCart($products){
    ?>
    <article id = "productsTable">
            <table>
                <tr><th>Name</th><th>Price</th></tr>
                <?php foreach($products as $product){
                    ?>
                    <tr id = "<?= $product->getId()?>"><td><?= $product->getName() ?></td><td class = "price"><?= $product->getPrice()?></td><td><button>Delete</button></td></tr>
                <?php } ?>
                <tr><th>Total</th><td id="totalPrice"><?= calculatePrice($products) ?></td></tr>
            </table>
        </article>
<?php }