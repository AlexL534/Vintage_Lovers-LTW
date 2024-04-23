<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/product.class.php');

function drawFilterTypes() {
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

function drawAddInfoForm($filterType) {?>
    <section id="addInfoForm">
        <header>
            <h2><?php echo ucfirst($filterType); ?></h2>
        </header>
        <form action="../actions/add_filter.php" method="post">
            <label>Name: <input type="text" name="name" required></label>
            <?php if ($filterType === 'category' || $filterType === 'condition'): ?>
            <label>Description: <input type="text" name="description" required></label>
            <?php endif; ?>
            <input type="submit" name="add" value="Add">
        </form>
    </section>
    <?php
}

function searchUsers($searchQuery) {
    try {
        $db = getDatabaseConnection();
        
        $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE :search_query");
        $stmt->bindValue(':search_query', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->execute();
        
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $searchResults;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function drawUserList() {
    try {
        ?>
        <header>
            <h2>User List</h2>
        </header>
        <section id="userSearch">
            <form action="" method="post">
                <label for="search">Search for user</label>
                <input type="text" id="search" name="search">
                <button type="submit">Search</button>
                <input type="hidden" name="action" value="search">
            </form>
        </section>
        <?php

        if (isset($_POST['action']) && $_POST['action'] === 'search') {
            $searchQuery = $_POST['search'];
            $searchResults = searchUsers($searchQuery);
            
            if (!empty($searchResults)) {
                ?>
                <section id="userList">
                    <ul>
                        <?php foreach ($searchResults as $user) { ?>
                            <li>
                                <span class="username"><?php echo $user['username']; ?></span>
                                <span class="email"><?php echo $user['email']; ?></span>
                                <form action="admin_elevate_user.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="elevate-btn">Elevate to Admin</button>
                                </form>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
                <?php
            } else {
                echo "No users found.";
            }
        } else {
            $users = User::getAllUsers(getDatabaseConnection());
        
            if (!empty($users)) {
                ?>
                <section id="userList">
                    <ul>
                        <?php foreach ($users as $user) { ?>
                            <li>
                                <span class="username"><?php echo $user->getUsername(); ?></span>
                                <span class="email"><?php echo $user->getEmail(); ?></span>
                                <form action="../actions/elevate_admin.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <button type="submit" class="elevate-btn">Elevate to Admin</button>
                                </form>
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
        echo "Error: " . $e->getMessage();
    }
}

function searchProducts($searchQuery) {
    try {
        $db = getDatabaseConnection();
        
        $stmt = $db->prepare("SELECT * FROM PRODUCTS WHERE NAME LIKE :search_query");
        $stmt->bindValue(':search_query', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->execute();
        
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $searchResults;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function drawProductList($searchEnabled = true) {
    try {
        ?>
        <header>
            <h2><?php echo $searchEnabled ? "Product List" : "Your Product List"; ?></h2>
        </header>
        <?php

        if ($searchEnabled) {
            ?>
            <section id="productSearch">
                <form action="" method="post">
                    <label for="search">Search for product</label>
                    <input type="text" id="search" name="search">
                    <button type="submit">Search</button>
                    <input type="hidden" name="action" value="search">
                </form>
            </section>
            <?php
        }

        // Process search or display all products
        if (isset($_POST['action']) && $_POST['action'] === 'search') {
            $searchQuery = $_POST['search'];
            $searchResults = searchProducts($searchQuery);
            displayProductResults($searchResults, $searchEnabled); 
        } else {
            $db = getDatabaseConnection();
            $products = Product::getAllProducts($db);
            displayProductResults($products, $searchEnabled);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function displayProductResults($products, $searchEnabled) {
    // Display products
    if (!empty($products)) {
        ?>
        <section id="productList">
            <ul>
                <?php if (!$searchEnabled) { ?> 
                    <a href="../pages/seller_add_product.php">+</a>
                <?php } ?>
                <?php foreach ($products as $product) { ?>
                    <li>
                        <span class="product_name"><?php echo $product instanceof Product ? $product->getName() : $product['name']; ?></span>
                        <button class="check-info-btn">Check info</button>
                        <form action="../actions/delete_product.php" method="post" class="delete-form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="product_id" value="<?php echo $product instanceof Product ? $product->getId() : $product['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                        <?php if (!$searchEnabled) { ?>
                            <button class="update-info-btn" data-product-id="<?php echo $product instanceof Product ? $product->getId() : $product['id']; ?>">Update Info</button>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <?php
    } else {
        echo "No products found.";
    }
}

function drawAddProductForm() {
    ?>
    <header>
        <h2>Add Product</h2>
    </header>
    <section id="addProductForm">
        <form action="../actions/add_product.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" name="description" id="description" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" min="0" id="price" required>
            </div>
            <input type="submit" value="submit">
        </form>
    </section>
    <?php
}

?>