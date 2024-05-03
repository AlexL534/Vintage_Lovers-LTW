<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/image.class.php');

function drawProductInfo(PDO $db, int $id){
    $product = product::getProduct($db,$id);
    //var_dump($product);
    
    $brand = Brand::getBrandById($db,$product->getBrand());
    $category = Category::getCategoryById($db,$product->getCategory());
    $colors = Color::getColorsOfProduct($db,$id);
    $conditions = Condition::getConditionsOfProduct($db,$id);
    $sizes = Size::getSizesOfProduct($db,$id);
    
?>
    <section class="productInfo">
        <p>Price: <?=  $product->getPrice(); ?></p>
        <p>Brand: <?= $brand->getName(); ?></p>
        <p>Category: <?= $category->getName(); ?></p>
        <ul>
            <?php foreach($colors as $color){ ?>
                <p><?= $color->getName();?></p>
            <?php }?>
        </ul>
        <ul>
            <?php foreach($conditions as $condition){ ?>
                <p><?= $condition->getName();?></p>
            <?php }?>
        </ul>
        <ul>
            <?php foreach($sizes as $size){ ?>
                <p><?= $size->getName();?></p>
            <?php }?>
        </ul>
    </section>

<?php } ?>

