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
    $stmt->execute([$id]);
    $colors = [];
    while($colorID = $stmt->fetchColumn()){
        $color = Color::getColorById($db,intval($colorID));
        if ($color) {
            $colors[] = $color;
        }
    }
    return $colors;
}

function getConditionsOfProduct(PDO $db , int $id){
    $stmt = $db->prepare('SELECT conditionID FROM CONDITION_OF_PRODUCT WHERE productID = ?');
    $stmt->execute([$id]);
    $conditions = [];
    while($conditionID=$stmt->fetchColumn()){
        $condition = Condition::getConditionById($db,intval($conditionID));
        if ($condition) {
            $conditions[] = $condition;
        }
    }
    return $conditions;
}

function getSizesOfProduct(PDO $db , int $id){
    $stmt = $db->prepare('SELECT sizeID FROM SIZE_OF_PRODUCT WHERE productID = ?');
    $stmt->execute([$id]);
    $sizes = [];
    while ($sizeID = $stmt->fetchColumn()) {
        $size = Size::getSizeById($db, (int)$sizeID);
        if ($size) {
            $sizes[] = $size;
        }
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
        <p>Price: <?= htmlentities($product->getPrice()); ?></p>
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
<?php } ?>

