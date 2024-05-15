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
require_once(__DIR__ . '/../classes/user.class.php');

function drawProductInfo(PDO $db, int $id, Session $session){
    //draws the product info in the product page

    $product = product::getProduct($db,$id);
    $productID = $product->getId();
    $ownerID = $product->getOwner();
    $owner = User::getUser($db, $ownerID);
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
        <article id="productInfo">
            <table>
                <tr><th><p>Price: </p></th><td><p><?= $product->getPrice(); ?>€</p></td></tr>
                <tr><th><p>Brand:</p></th><td><p><?= $brand ? htmlentities($brand->getName()) : 'Unknown'; ?></p></td></tr>
                <tr><th><p>Category: </p></th><td><p><?= $category ? htmlentities($category->getName()) : 'Unknown'; ?></p></td></tr>
                <tr><th><p> Color: </p></th><td><?php 
                        if(empty($colors)) {echo "Unknown";} 
                        else{ foreach ($colors as $color) { ?>
                            <p><?= htmlentities($color->getName()); ?></p>
                        <?php  } } ?></td></tr>

                <tr><th><p> Condition: </p></th><td><?php 
                        if(empty($conditions)) {echo "Unknown";} 
                        else{
                            foreach ($conditions as $condition) { ?>
                                    <p><?= htmlentities($condition->getName()); ?></p>
                            <?php } }?></td></tr>

                <tr><th><p> Size: </p></th><td><?php 
                        if(empty($sizes)) {echo "Unknown";} 
                        else{
                            foreach ($sizes as $size) { ?>
                                    <p><?= htmlentities($size->getName()); ?></p>
                            <?php }} ?></td></tr>

                <tr><th><p>Owner: </p></th><td><p><?= $owner->getUsername(); ?></p></td></tr>
            </table>
        </article>
        <article id="productImages">
                    <?php $image = $images[0]?>    
                    <img src="/../<?=$image; ?>" alt="product image" id= "<?= $productID?>">
                    <?php if(count($images) > 1){ ?>
                        <button>Next Image</button>
                   <?php } ?>       
        </article>
        <div id = "productButtons">
            
            <?php drawProductPageButtons($session, $productID) ?>
        </div>
        
    </section>

<?php } ?>

<?php function drawProductPageButtons(Session $session, int $id){ 
    //draws the buttons used to add the product to the wishlist and to the shopping cart
    
    if($session->isLoggedIn()){
        ?>
        <form>
            <input type="hidden" name = "productID" value = "<?= $id ?>">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button formaction="/../actions/action_add_wishlist.php" formmethod="post" type="submit" >Add to the Wishlist</button>
            <button formaction="/../actions/action_add_shopping_cart.php" formmethod="post" type="submit" >Add to the Cart</button>
        </form>  
    <?php } ?>    



<?php } ?>


