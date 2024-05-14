<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/product.class.php');
require_once(__DIR__ . '/../classes/brand.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
require_once(__DIR__ . '/../classes/color.class.php');
require_once(__DIR__ . '/../classes/condition.class.php');
require_once(__DIR__ . '/../classes/size.class.php');
require_once(__DIR__ . '/../classes/session.class.php');


function drawFilterTypes() {
    //draws the filter selection page used to insert new filters
    ?>
    <header>
        <h2>Add info to the system</h2>
    </header>
    <section id="filterTypes">
        <ul>
            <li><a href="admin_specific_filter.php?type=category"><?php echo 'Categories'; ?></a></li>
            <li><a href="admin_specific_filter.php?type=size"><?php echo 'Sizes'; ?></a></li>
            <li><a href="admin_specific_filter.php?type=condition"><?php echo 'Conditions'; ?></a></li>
            <li><a href="admin_specific_filter.php?type=color"><?php echo 'Colors'; ?></a></li>
            <li><a href="admin_specific_filter.php?type=brand"><?php echo 'Brands'; ?></a></li>
        </ul>
    </section>
    <?php
}

function drawRemoveFilterTypes() {
    ?>
    <header>
        <h2>Remove info from the system</h2>
    </header>
    <section id="removeFilterTypes">
        <ul>
            <li><a href="admin_remove_specific_filter.php?type=category"><?php echo 'Categories'; ?></a></li>
            <li><a href="admin_remove_specific_filter.php?type=size"><?php echo 'Sizes'; ?></a></li>
            <li><a href="admin_remove_specific_filter.php?type=condition"><?php echo 'Conditions'; ?></a></li>
            <li><a href="admin_remove_specific_filter.php?type=color"><?php echo 'Colors'; ?></a></li>
            <li><a href="admin_remove_specific_filter.php?type=brand"><?php echo 'Brands'; ?></a></li>
        </ul>
    </section>
    <?php
}

function drawRemoveInfoForm($filterType, $db) {
    $tableName = strtoupper($filterType);
    $columnName = $tableName . 'ID';
    $query = "SELECT $columnName, name FROM $filterType";

    $stmt = $db->query($query);

    if ($stmt) {
        ?>
        <section id="removeInfoForm">
            <header>
                <h2>Remove <?php echo ucfirst($filterType); ?></h2>
            </header>
            <form action="/../actions/action_remove_filter.php" method="post">
                <label>Select <?php echo ucfirst($filterType); ?> to remove:</label>
                <select name="filter_name" required>
                    <option value="" disabled selected>Select <?php echo ucfirst($filterType); ?></option> 
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row['name'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($row['name'] ?? '', ENT_QUOTES); ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="hidden" name="filter_type" value="<?php echo $filterType; ?>">
                <input type="submit" name="remove" value="Remove">
            </form>
        </section>
        <?php
    } else {
        echo "Failed to retrieve data from the database.";
    }
}

function drawAddInfoForm($filterType) {
    //draws the add information page
    ?>
    <section id="addInfoForm">
        <header>
            <h2><?php echo ucfirst($filterType); ?></h2>
        </header>
        <form action="/../actions/action_add_filter.php" method="post">
            <label>Name: <input type="text" name="name" required></label>
            <?php if ($filterType === 'category' || $filterType === 'condition'): ?>
            <label>Description: <input type="text" name="description"></label>
            <?php endif; ?>
            <input type="hidden" name="filter_type" value="<?php echo $filterType; ?>">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" name="add" value="Add">
            
        </form>
    </section>
    <?php
}

function drawUserList($db, $session) {
    //draws the website's users list
    try {
        $userType = isset($_POST['userType']) ? filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING) : 'all';
        ?>
        <header>
            <h2>User List</h2>
        </header>
        <section id="userSearch">
            <form method="post">
                <select name="userType" id="userType">
                    <option value="all" <?= ($userType === 'all') ? 'selected' : '' ?>>All</option>
                    <option value="admin" <?= ($userType === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="normal" <?= ($userType === 'normal') ? 'selected' : '' ?>>Normal User</option>
                </select>
                <input type="text" id="search" name="search" placeholder="Search for user">
                <input type="hidden" name="action" value="search">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" class = "token">
            </form>
        </section>
        <?php





        if (isset($_POST['action']) && $_POST['action'] === 'search') {

            if ($_SESSION['csrf'] !== $_POST['csrf']) {
                $session->addMessage('error', 'Suspicious activity found');
                header('Location: /../pages/main_page.php');
                exit();
            }

            $searchQuery = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);
            $searchResults = User::searchUsers($db, $searchQuery, $userType);
            
            if (!empty($searchResults)) {
                ?>
                <section id="userList">
                    <ul>
                        <?php foreach ($searchResults as $user) { ?>
                            <li class="user-item">
                                <div class="user-label username-light">Username</div>
                                <div class="user-details">
                                    <span><?php echo htmlentities($user['username']); ?></span>
                                </div>
                                <div class="user-label email-light">Email</div>
                                <div class="user-details">
                                    <span><?php echo htmlentities($user['email']); ?></span>
                                </div>
                                <div class="user-label">User Type</div>
                                <div class="user-details">
                                    <span><?php echo htmlentities($user['is_admin']) ? 'Admin' : 'Normal User'; ?></span>
                                </div>
                                <div class="options-menu">
                                    <form action="/../actions/action_delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete this account?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlentities($user['id']); ?>">
                                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" class = "token">
                                        <button type="submit" class="delete-btn">Delete Account</button>
                                    </form>
                                    <form action="/../actions/action_elevate_admin.php" method="post" onsubmit="return confirm('Are you sure you want to elevate this user to admin?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlentities($user['id']); ?>">
                                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" class = "token">
                                        <button type="submit" class="elevate-btn">Elevate to Admin</button>
                                    </form>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
                <?php
            } else {
                echo "No users found.";
            }
        } else {
            $users = User::getAllUsers($db);
        
            if (!empty($users)) {
                ?>
                <section id="userList">
                    <ul>
                        <?php foreach ($users as $user) { ?>
                            <li class="user-item">
                                <div class="user-label username-light">Username</div>
                                <div class="user-details">
                                    <span><?= htmlspecialchars($user->getUsername()) ?></span>
                                </div>
                                <div class="user-label email-light">Email</div>
                                <div class="user-details">
                                    <span><?= htmlspecialchars($user->getEmail()) ?></span>
                                </div>
                                <div class="user-label">User Type</div>
                                <div class="user-details">
                                    <span><?= htmlspecialchars($user->getIsAdmin()) ? 'Admin' : 'Normal User' ?></span>
                                </div>
                                <div class="options-menu">
                                    <form action="/../actions/action_delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete this account?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlentities($user->getId()); ?>">
                                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" class = "token">
                                        <button type="submit" class="delete-btn">Delete Account</button>
                                    </form>
                                    <form action="/../actions/action_elevate_admin.php" method="post" onsubmit="return confirm('Are you sure you want to elevate this user to admin?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlentities($user->getId()); ?>">
                                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" class = "token">
                                        <button type="submit" class="elevate-btn">Elevate to Admin</button>
                                    </form>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
                <?php
            } else {
                echo "No users found.";
            }
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }
}

function drawProductList($searchEnabled = true, $session) {
    //draws the section where the owned products are content of the page where the products are showned
    try {
        ?>
        <section id = "products-del-info-page" >
        <header>
            <h1><?php echo $searchEnabled ? "Product List" : "Your Product List"; ?></h1>
        </header>
        <?php

        if ($searchEnabled) {
            ?>
            <section id="productSearch">
                <form  method="post">
                    <label for="search">Search for product</label>
                    <input type="text" id="search" name="search">
                    <button type="submit">Search</button>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <input type="hidden" name="action" value="search">
                </form>
            </section>
            <?php
        }



        if (isset($_POST['action']) && $_POST['action'] === 'search') {

            if ($_SESSION['csrf'] !== $_POST['csrf']) {
                $session->addMessage('error', 'Suspicious activity found');
                header('Location: /../pages/main_page.php');
                exit();
            }
            
            try {
                $searchQuery = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);
                $db = getDatabaseConnection();
                $searchResults = Product::searchProducts($db, $searchQuery);
                displayProductResults($searchResults, $searchEnabled, $session);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            try {
                $db = getDatabaseConnection();
                $products = Product::getAllProducts($db);
                displayProductResults($products, $searchEnabled, $session);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    ?>
        </section> 
    <?php
}

function displayProductResults($products, $searchEnabled, $session) {
    //draws the section where the owned products are showned

    if (!empty($products)) {
        ?>
        <section id="productList">
            <?php if (!$searchEnabled) { ?> 
                    <a href="/../pages/seller_add_product.php">+</a>
            <?php } ?>
            <ul>
                <?php foreach ($products as $product) {
                    if ($searchEnabled) { ?>
                        <li>
                            <span class="product_name"><?php echo $product instanceof Product ? htmlentities($product->getName()) : htmlentities($product['name']); ?></span>
                            <form action="/../actions/action_delete_product.php" method="post" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?php echo $product instanceof Product ? htmlentities($product->getId()) : htmlentities($product['id']); ?>">
                                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                            <?php if (!$searchEnabled) { ?>
                                <a href="/../pages/seller_update_info.php?id=<?php echo $product instanceof Product ? htmlentities($product->getId()) : htmlentities($product['id']); ?>"><p><?php echo 'Update Info'; ?></p></a>
                            <?php } ?>
                        </li>
                    <?php } else {
                        $ownerId = $product instanceof Product ? $product->getOwner() : $product['owner'];
                        $loggedInUserId = $session->getId();

                        if ($ownerId === $loggedInUserId) { ?>
                            <li>
                                <span class="product_name"><p><?php echo $product instanceof Product ? htmlentities($product->getName()) : htmlentities($product['name']); ?></p></span>
                                <form action="/../actions/action_delete_product.php" method="post" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_id" value="<?php echo $product instanceof Product ? htmlentities($product->getId()) : htmlentities($product['id']); ?>">
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                                <?php if (!$searchEnabled) { ?>
                                    <a href="/../pages/seller_update_info.php?id=<?php echo $product instanceof Product ? htmlentities($product->getId()) : htmlentities($product['id']); ?>"><p><?php echo 'Update Info'; ?></p></a>
                                <?php } ?>
                            </li>
                    <?php }
                    }
                } ?>
            </ul>
        </section>
        <?php
    } else {
        echo "No products found.";
    }
}

function drawAddProductForm() {
    //draws the section where the user can add a product

    $db = getDatabaseConnection();
    $brands = Brand::getAllBrands($db);
    $categories = Category::getAllCategories($db);
    $colors = Color::getAllColors($db);
    $sizes = Size::getAllSizes($db);
    $conditions = Condition::getAllCondition($db);

    ?>
    <section id="addProduct">
    <header>
        <h1>Add Product</h1>
    </header>
    <section id="addProductForm">
        <form action="/../actions/action_add_product.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" name="description" id="description" required>
            </div>
            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand" id="brand" required>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand->getId(); ?>"><?= htmlspecialchars($brand->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->getId(); ?>"><?= htmlspecialchars($category->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <select name="color" id="color" required>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?= $color->getId(); ?>"><?= htmlspecialchars($color->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="condition">Condition:</label>
                <select name="condition" id="condition" required>
                    <?php foreach ($conditions as $condition): ?>
                        <option value="<?= $condition->getId(); ?>"><?= htmlspecialchars($condition->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="size">Sizes:</label>
                <select name="size" id="size" required>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?= $size->getId(); ?>"><?= htmlspecialchars($size->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" min="0" id="price" required>
            </div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" name="submit" value="Submit">
        </form>
    </section>
    </section>
    <?php
}

function drawUpdateInfoForm($product_id) {
    //draws the section where the user can update the product info

    $db = getDatabaseConnection();
    $product = Product::getProduct($db, $product_id);
    $productName = $product->getName();
    $productDescription = $product->getDescription();
    $productPrice = $product->getPrice();

    ?>
    <section id="updateProduct">
    <header>
        <h1>Update Product</h1>
    </header>
    <section id="updateProductForm">
        <form action="/../actions/action_update_product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div class="form-group">
                <label for="name"><p>Name:</p></label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productName); ?>" required>
            </div>
            <div class="form-group">
                <label for="description"><p>Description:</p></label>
                <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($productDescription); ?>" required>
            </div>
            <div class="form-group">
                <label for="price"><p>Price:</p></label>
                <input type="number" name="price" step="0.01" min="0" id="price" value="<?php echo htmlspecialchars($productPrice); ?>" required>
            </div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" name="submit" value="Update">
        </form>
    </section>
    </section>
    <?php
}

function drawAddImages($productId, $session){
    //draws the add images section where the user can insert images to the products
    ?>
    <section id = "insertImages">
    <?php displayMessages($session)?>
    <header>
        <h1>Insert images for your product</h1>
    </header>
    <form action="/../actions/action_add_image.php" method="post" enctype="multipart/form-data">
        <label>
            <p>Title:</p>
            <input type="text" name="title" required>
        </label>
        <input type="file" name="image[]" multiple="multiple"  required>
        <input type="hidden" name="productID" value ="<?=$productId?>">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Upload">
      </form>
    </section>

<?php }

?>