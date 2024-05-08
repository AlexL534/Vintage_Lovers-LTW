<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/image.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

function drawProductInfo(PDO $db, int $id, Session $session){
    $product = product::getProduct($db,$id);
    //var_dump($product);
    
    $brand = Brand::getBrandById($db,$product->getBrand());
    $category = Category::getCategoryById($db,$product->getCategory());
    $colors = Color::getColorsOfProduct($db,$id);
    $conditions = Condition::getConditionsOfProduct($db,$id);
    $sizes = Size::getSizesOfProduct($db,$id);
    $images = Image::getImagesPath($db,$id);
    
?>
    <section id="productPage">
        <header>
            <h1><?= $product->getName();?></h1>
        </header>
        <section id="productInfo">
            <p>Price: <?= $product->getPrice(); ?></p>
            <p>Brand: <?= $brand ? htmlentities($brand->getName()) : 'Unknown'; ?></p>
            <p>Category: <?= $category ? htmlentities($category->getName()) : 'Unknown'; ?></p>
            <ul>
                <?php foreach ($colors as $color) { ?>
                    <li><?= htmlentities($color->getName()); ?></li>
                <?php } ?>
            </ul>
            <ul>
                <?php foreach ($conditions as $condition) { ?>
                    <li><?= htmlentities($condition->getName()); ?></li>
                <?php } ?>
            </ul>
            <ul>
                <?php foreach ($sizes as $size) { ?>
                    <li><?= htmlentities($size->getName()); ?></li>
                <?php } ?>
            </ul>
        </section>
        <section id="productImages">
                    <?php foreach($images as $image){ ?>
                        
                        <img src="../<?=$image; ?>" alt="">
                    <?php } ?>
        </section>
        <div id = "productButtons">
            <?php drawAddToShoppingCart($session) ?>
            <?php drawAddToWishlist($session) ?>
        </div>
        
    </section>

<?php } ?>

<?php function drawAddToShoppingCart(Session $session){ 
    if($session->isLoggedIn()){
        ?>
        <form action="../actions/action_add_shopping_cart.php" id = "addShoppingCart">
            <button >Add to the Cart</button>
        </form>  
    <?php } ?>    



<?php } ?>

<?php function drawAddToWishlist(Session $session){ 
    if($session->isLoggedIn()){
        ?>
        <form action="../actions/action_add_wishlist.php " id = "addWishlist">
            <button >Add to the Wishlist</button>
        </form>
    <?php } ?>    



<?php } ?>

