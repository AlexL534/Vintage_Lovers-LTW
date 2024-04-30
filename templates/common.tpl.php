<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/sessions.php');

function drawHeader(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/general_style.css">
            <link rel="stylesheet" href="../css/general_layout.css">
            <link rel="stylesheet" href="../css/main_layout.css">
            <link rel="stylesheet" href="../css/main_style.css">
            <link rel="stylesheet" href="../css/general_responsive.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <head>
        <body>
            <header>
                   <a href="../pages/main_page.php"><img src="../docs/Logo3.png" alt= "logo" id = "logo"></a>
                   <form>
                        <input type="search" name="search" placeholder="Search for a brand, condition, ...">
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
                    <li><a href="">Shoes</a></li>
                    <li><a href="">Shirts</a></li>
                    <li><a href="">Pants</a></li>
                    <li><a href="">All</a></li>
                </menu>
            </nav>
            <main>
                
    <?php }

function drawFooter() { ?>
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
    <html>
<?php }

function drawHeaderLogin() { ?>
    <div class= "login" >
        <a href="../pages/register.php">Register</a>
        <a href="../pages/login.php">Login</a>
    </div>
<?php }

function drawLoggedInIcons(){ ?>
    <div id= "logged_icons">
        <a href = ""><img src = "../assets/shopping_cart.png" alt = "shopping cart icon" id = "cart_icon"></a>
        <a href="../pages/profile.php"><img src= "../assets/profile_icon.png" alt= "profile icon" id =" profile_icon" ></a>
    </div>
<?php }

function displayMessages(Session $session){ ?>
    <section id="messages">
      <?php foreach ($session->getMessages() as $message) { ?>

        <article class="<?=$message['type']?>">
          <?=$message['text']?>
        </article>

      <?php } ?>
    </section>
<?php }
