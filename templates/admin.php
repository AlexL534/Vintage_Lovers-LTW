<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');

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

function drawAddInfoForm($filterType) {
    ?>
    <header>
        <h2><?php echo ucfirst($filterType); ?></h2>
    </header>
    <section id="addInfoForm">
        <form action="/../actions/add_filter.php" method="post">
            <input type="hidden" name="type" value="<?php echo $filterType; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <?php if ($filterType === 'category' || $filterType === 'condition'): ?>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <?php endif; ?>
                <button type="submit">Add</button>
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
            <form action="" method="get">
                <label for="search">Search for user</label>
                <input type="text" id="search" name="search">
                <button type="submit">Search</button>
                <input type="hidden" name="action" value="search">
            </form>
        </section>
        <?php

        if (isset($_GET['action']) && $_GET['action'] === 'search') {
            $searchQuery = $_GET['search'];
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
                                <form action="/../actions/elevate_admin.php" method="post">
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
                <form action="" method="get">
                    <label for="search">Search for product</label>
                    <input type="text" id="search" name="search">
                    <button type="submit">Search</button>
                    <input type="hidden" name="action" value="search">
                </form>
            </section>
            <?php
        }

        // Process search or display all products
        if (isset($_GET['action']) && $_GET['action'] === 'search') {
            $searchQuery = $_GET['search'];
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
                    <a href="/../pages/seller_add_product.php"><?php echo '+'; ?></a>
                <?php } ?>
                <?php foreach ($products as $product) { ?>
                    <li>
                        <span class="product_name"><?php echo $product instanceof Product ? $product->getName() : $product['name']; ?></span>
                        <button class="check-info-btn">Check info</button>
                        <button class="delete-  ">Delete</button>
                        <?php if (!$searchEnabled) { ?> <!-- Display update info button only if search is not enabled -->
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
        <h2>Add Product Info</h2>
    </header>
    <section id="addProductForm">
        <form action="/../actions/add_product.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required step="0.01" min="0">
            </div>
            <button type="submit" name="submit">Add</button>
        </form>
    </section>
    <?php
}

?>