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
            <table>
                <tr><th><p>Price: </p></th><td><p><?= $product->getPrice(); ?></p></td></tr>
                <tr><th><p>Brand:</p></th><td><p><?= $brand ? htmlentities($brand->getName()) : 'Unknown'; ?></p></td></tr>
                <tr><th><p>Category: </p></th><td><p><?= $category ? htmlentities($category->getName()) : 'Unknown'; ?></p></td></tr>
                <tr><th><p> Color: </p></th><td><?php foreach ($colors as $color) { ?>
                        <p><?= htmlentities($color->getName()); ?></p>
                <?php } ?></td></tr>
                <tr><th><p> Condition: </p></th><td><?php foreach ($conditions as $condition) { ?>
                        <p><?= htmlentities($condition->getName()); ?></p>
                <?php } ?></td></tr>
                <tr><th><p> Size: </p></th><td><?php foreach ($sizes as $size) { ?>
                        <p><?= htmlentities($size->getName()); ?></p>
                <?php } ?></td></tr>

            </table>
        </section>
        <section id="productImages">
                    <?php foreach($images as $image){ ?>
                        
                        <img src="../<?=$image; ?>" alt="">
                    <?php } ?>
        </section>
        <div id = "productButtons">
            <?php drawProductPageButtons($session, $id) ?>
        </div>
        
    </section>

<?php } ?>

<?php function drawProductPageButtons(Session $session, int $id){ 
    if($session->isLoggedIn()){
        ?>
        <form>
            <input type="hidden" name = "productID" value = "<?= $id ?>">
            <button formaction="../actions/action_add_whishlist.php" formmethod="post" type="submit" >Add to the Wishlist</button>
            <button formaction="../actions/action_add_shopping_cart.php" formmethod="post" type="submit" >Add to the Cart</button>
        </form>  
    <?php } ?>    



<?php } ?>


