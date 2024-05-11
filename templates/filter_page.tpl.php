<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/image.class.php');



function drawFilterSection(PDO $db){ 
    $brands = Brand::getAllBrands($db);
    $sizes = Size::getAllSizes($db);
    $conditions = Condition::getAllCondition($db);
    $colors = Color::getAllColors($db);
    $categories = Category::getAllCategories($db);
    ?>
    <section id="filtersSection">
        <ul id="brands">
            <?php foreach($brands as $brand){?>
                <li>
                    <label><?=htmlentities($brand->getName());?>
                        <input type="checkbox" name="<?=$brand->getName()?>" class="filter">
                    </label>
                </li>
            <?php } ?>

        </ul>
        <ul id="categories">
            <?php foreach($categories as $category){?>
                <li>
                    <label><?=htmlentities($category->getName());?>
                        <input type="checkbox" name="<?=$category->getName()?>" class="filter">
                    </label>
                </li>
            <?php } ?>

        </ul>
        <ul id="colors">
            <?php foreach($colors as $color){?>
                <li>
                    <label><?=htmlentities($color->getName());?>
                        <input type="checkbox" name="<?=$color->getName()?>" class="filter">
                    </label>
                </li>
            <?php } ?>

        </ul>
        <ul id="conditions">
            <?php foreach($conditions as $condition){?>
                <li>
                    <label><?=htmlentities($condition->getName());?>
                        <input type="checkbox" name="<?=$condition->getName()?>" class="filter">
                    </label>
                </li>
            <?php } ?>

        </ul>
        <ul id="sizes">
            <?php foreach($sizes as $size){?>
                <li>
                    <label><?=htmlentities($size->getName());?>
                        <input type="checkbox" name="<?=$size->getName()?>" class="filter">
                    </label>
                </li>
            <?php } ?>

        </ul>

    </section>
<?php }

function drawProductArticle(PDO $db, Product $product){ ?>
    <a href="../pages/products.php?id=<?=$product->getId();?>" class="product">
        <article>
            <?php
                $images = Image::getImagesPath($db,$product->getId());
                $name = $product->getName();?>
                <img src="../<?=$images[0]?>" alt="productImage" class="productImage">
                <p><?=htmlentities($product->getName());?></p>
                <p><?=$product->getPrice();?></p>

        </article>
    </a>
    
<?php }
?>

<?php function drawProductSection(PDO $db){
    $products = Product::getAllProducts($db);?>
    <section id="products">
        <?php foreach($products as $product)
            drawProductArticle($db,$product);
        ?>
    </section>
<?php } ?>