<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');

function getColorsOfProduct(PDO $db , int $id){
    $stmt = $db->prepare('SELECT colorID FROM COLORS_OF_PRODUCT WHERE productID = ?');
    $stmt->execute(array($id));
    $colors = array();
    while($colorID=$stmt->fetch()){
        $color = Color::getColorById($db,intval($colorID));
        $colors[] = $color;
    }
    return $colors;
}

function getConditionsOfProduct(PDO $db , int $id){
    $stmt = $db->prepare('SELECT conditionID FROM CONDITION_OF_PRODUCT WHERE productID = ?');
    $stmt->execute(array($id));
    $conditions = array();
    while($conditionID=$stmt->fetch()){
        $condition = Condition::getConditionById($db,intval($conditionID));
        $conditions[] = $condition;
    }
    return $conditions;
}

function getSizesOfProduct(PDO $db , int $id){
    $stmt = $db->prepare('SELECT sizeID FROM SIZE_OF_PRODUCT WHERE productID = ?');
    $stmt->execute(array($id));
    $sizes = array();
    while($sizeID=$stmt->fetch()){
        $size = Size::getSizeById($db,intval($sizeID));
        $sizes[] = $size;
    }
    return $sizes;
}

function drawProductInfo(PDO $db, int $id){
    $product = product::getProduct($db,$id);
    //var_dump($product);
    
    $brand = Brand::getBrandById($db,$product->getBrand());
    $category = Category::getCategoryById($db,$product->getCategory());
    $colors = getColorsOfProduct($db,$id);
    $conditions = getConditionsOfProduct($db,$id);
    $sizes = getSizesOfProduct($db,$id);
    
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

