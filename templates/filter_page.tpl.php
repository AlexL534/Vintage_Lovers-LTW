<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/image.class.php');



function drawFilterSection(PDO $db, $categoryID, $search){ 
    //draws the filters section (sidebar)

    $brands = Brand::getAllBrands($db);
    $sizes = Size::getAllSizes($db);
    $conditions = Condition::getAllCondition($db);
    $colors = Color::getAllColors($db);
    $categories = Category::getAllCategories($db);
    ?>
    <section id="filterPage">
        <?php if($search !==null){
            ?> 
            <header>
                <h2>Your search results for: "<span><?=htmlentities($search)?></span>"</h2>
            </header>
        <?php } ?>
        <div id = "filterMenu">
            <header>
                <button type="button"><img src="/../assets/filter_icon.png" alt = "filter icon"></button>
                <h3>Filters</h3>
            </header>
            <aside>
                <h4>Brands</h4>
                <div class = "scrollable">
                    <ul id="brands">
                        <?php foreach($brands as $brand){?>
                            <li>
                                <label><p><?=htmlentities($brand->getName());?></p>
                                    <input type="checkbox" name="<?=$brand->getId()?>" class="filter" >
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
                                    <input type="checkbox" name="<?=$category->getId()?>" class="filter" <?= ($categoryID === $category->getId()) ? "checked": ""?>>
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
                                    <input type="checkbox" name="<?=$color->getId()?>" class="filter">
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
                                    <input type="checkbox" name="<?=$condition->getId()?>" class="filter">
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
                                    <input type="checkbox" name="<?=$size->getId()?>" class="filter">
                                </label>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </aside>
        </div>
        <div id="priceOrder">
            <label for="order"><p>Order by Price</p></label>
            <select name="order" id = "order">
                <option value="Asc">Ascending</option>
                <option value="Desc">Descending</option>
            </select>
        </div>

<?php }

function drawProductArticle(PDO $db, Product $product){ 
    //draws the given product article with its information
    ?>
    <a href="/../pages/products.php?id=<?=$product->getId();?>" class="product">
        <article>
            <?php
                $images = Image::getImagesPath($db,$product->getId());
                $name = $product->getName();?>
                <img src="/../<?=$images[0]?>" alt="productImage" class="productImage">
                <p class= "product_name"><?=htmlentities($name);?></p>
                <p class= "product_price"><?=$product->getPrice();?></p>

        </article>
    </a>
    
<?php }
?>

<?php function drawProductSection(PDO $db, $categoryID, $search){
    //draws the products section 

    $products = [];
    if($categoryID !== 0){
        $products = Product::getProductByCategory($db, $categoryID);
    }
    else if($search !== null){
        $productsDB = Product::searchProducts($db, $search);

        foreach($productsDB as $productDB){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
                intval($productDB['quantity']),
                $productDB['name'],
                $productDB['description'],
                intval($productDB['owner']),
                intval($productDB['category']),
                intval($productDB['brand'])
            );
            $products[] = $product;
        }

    }
    else{
        $products = Product::getAllProducts($db);
    }
    usort($products, fn($a, $b) => $a->getPrice() - $b->getPrice());
    ?>
    <section class="products">
       
        <?php foreach($products as $product)
            drawProductArticle($db,$product);
        ?>
    </section>
    </section>
<?php } ?>