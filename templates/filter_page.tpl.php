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
    <section id="filterPage">
    <aside id="filtersSection">
        <h4>Brands</h4>
        <div class = "scrollable">
            <ul id="brands">
                <?php foreach($brands as $brand){?>
                    <li>
                        <label><p><?=htmlentities($brand->getName());?></p>
                            <input type="checkbox" name="<?=$brand->getName()?>" class="filter">
                        </label>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <h4>Categories</h4>
        <div class = "scrollable">
            <ul id="categories">
                <?php foreach($categories as $category){?>
                    <li>
                        <label><p><?=htmlentities($category->getName());?></p>
                            <input type="checkbox" name="<?=$category->getName()?>" class="filter">
                        </label>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <h4>Colors</h4>
        <div class = "scrollable">
            <ul id="colors">
                <?php foreach($colors as $color){?>
                    <li>
                        <label><p><?=htmlentities($color->getName());?></p>
                            <input type="checkbox" name="<?=$color->getName()?>" class="filter">
                        </label>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <h4>Conditions</h4>
        <div class = "scrollable">
            <ul id="conditions">
                <?php foreach($conditions as $condition){?>
                    <li>
                        <label><p><?=htmlentities($condition->getName());?></p>
                            <input type="checkbox" name="<?=$condition->getName()?>" class="filter">
                        </label>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <h4>Sizes</h4>
        <div class = "scrollable">
            <ul id="sizes">
                <?php foreach($sizes as $size){?>
                    <li>
                        <label><p><?=htmlentities($size->getName());?></p>
                            <input type="checkbox" name="<?=$size->getName()?>" class="filter">
                        </label>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </aside>

<?php }

function drawProductArticle(PDO $db, Product $product){ ?>
    <a href="../pages/products.php?id=<?=$product->getId();?>" class="product">
        <article>
            <?php
                $images = Image::getImagesPath($db,$product->getId());
                $name = $product->getName();?>
                <img src="../<?=$images[0]?>" alt="productImage" class="productImage">
                <p class= "product_name"><?=htmlentities($product->getName());?></p>
                <p class= "product_price"><?=$product->getPrice();?></p>

        </article>
    </a>
    
<?php }
?>

<?php function drawProductSection(PDO $db){
    $products = Product::getAllProducts($db);?>
    <section class="products">
        <?php foreach($products as $product)
            drawProductArticle($db,$product);
        ?>
    </section>
    </section>
<?php } ?>