<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../classes/category.class.php');
function drawHeader(Session $session, array $menuCategories) { 
    //draws the website header
    ?> 
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="/../css/general.css">
            <link rel="stylesheet" href="/../css/auth.css">
            <link rel="stylesheet" href="/../css/main.css">
            <link rel="stylesheet" href="/../css/profile.css">
            <link rel="stylesheet" href="/../css/admin.css">
            <link rel="stylesheet" href="/../css/product.css">
            <link rel="stylesheet" href="/../css/shopping_cart.css">
            <link rel="stylesheet" href="/../css/wishlist.css">
            <link rel="stylesheet" href="/../css/all_filters.css">
            <link rel="stylesheet" href="/../css/sold_products.css">
            <script src = "/../javascript/img.js" defer></script>
            <script src = "/../javascript/shopping_cart.js" defer></script>
            <script src = "/../javascript/wishlist.js" defer></script>
            <script src = "/../javascript/sidebar.js" defer></script>
            <script src = "/../javascript/filters.js" defer></script>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <header>
                   <a href="/../pages/main_page.php"><img src="/../assets/Logo.png" alt= "logo" id = "logo"></a>
                   <form action="/../pages/filter_page.php" method="get">
                        <input type="search" name="search" placeholder="Search for a product">
                    </form>
                    <?php
                        if($session->isLoggedIn()) drawLoggedInIcons();
                        else drawHeaderLogin();
                    ?>
            </header>
            
            <nav id= "menu">
                <input type="checkbox" id="menu_button"> 
                <label class="menu_button" for="menu_button"></label>
                <menu>
                    <?php
                    foreach($menuCategories as $category){
                        ?>
                             <li><a href="/../pages/filter_page.php/?categoryID=<?=$category->getId()?>"><?=htmlentities($category->getName())?></a></li>
                    <?php }
                    ?>
                    <li><a href="/../pages/filter_page.php">All</a></li>
                </menu>
            </nav>
            <main>
                
    <?php }

function drawFooter() { 
    //draws the website footer
    ?>
            </main>

            <footer>
                <div id = "footer_contents">
                    <div id ="contacts">
                        <h3>Contacts</h3>
                        <p>Our phone number: 000 000 000</p>
                        <p>Our email: example@gmail.com</p>
                    </div>
                    <div id = "authors">
                        <h3>Made by</h3>
                        <p>Alexandre Lopes</p>
                        <p>Lucas Faria</p>
                        <p>Rafael Campeão</p>
                    </div>
                </div>
                <p>&copy; Vintage Lovers 2024</p>
            </footer>
        </body>
    </html>
<?php }

function drawHeaderLogin() { 
    //draws the website header login
    ?>
    <div class= "login" >
        <a href="/../pages/register.php">Register</a>
        <a href="/../pages/login.php">Login</a>
    </div>
<?php }

function drawLoggedInIcons(){ 
    //draws the website icons when the user is loggedIn
    ?>
    <div id= "logged_icons">
        <a href = "/../pages/shopping_cart.php"><img src = "/../assets/shopping_cart.png" alt = "shopping cart icon" id = "cart_icon"></a>
        <a href="/../pages/profile.php"><img src= "/../assets/profile_icon.png" alt= "profile icon" id ="profile_icon" ></a>
    </div>
<?php }

function displayMessages(Session $session){ 
    //draws the error messages 
    ?>
    <section id="messages">
      <?php foreach ($session->getMessages() as $message) { ?>

        <article class="<?=htmlspecialchars($message['type'])?>">
          <?=htmlspecialchars($message['text'])?>
        </article>

      <?php } ?>
    </section>
<?php }
