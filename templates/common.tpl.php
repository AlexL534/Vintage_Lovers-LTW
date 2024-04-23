<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/sessions.php');
//change in name related to problem written down there
function drawHeader2(Session $session) { ?> 
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/layout.css">
        </head>
        <body>
            <header>
                   <a href="../pages/index.php"><img src="../docs/Logo3.png" alt= "logo" id = "logo"></a>
                   <form>
                        <input type="search" name="search" placeholder="Search for a brand, condition, ...">
                    </form>
                    <?php
                        if($session->isLoggedIn()) drawLogout($session);
                        else drawHeaderLogin();
                    ?>
            </header>
            
            <nav id= "menu">
                <input type="checkbox" id="menu_button"> 
                <menu>
                    <li><a href="">Shoes</a></li>
                    <li><a href="">Shirts</a></li>
                    <li><a href="">Pants</a></li>
                    <li><a href="">All</a></li>
                </menu>
            </nav>
            <main>
                
    <?php }
//this is just because my pages are not ready to use header with session parameter - Alex
function drawHeader() { ?> 
    <!DOCTYPE html>
    <html lang="en-US"> 
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
        </head>
        <body>
            <header>
                    <img src="../docs/Logo3.png" alt= "logo">
                    <form>
                        <input type="search" name="search" placeholder="type">
                    </form>
            </header>
            <?php drawSignUp()?>
            <nav id= "menu">
                <input type="checkbox" id="menu_button"> 
                <menu>
                    <li><a href="">shoes</a></li>
                    <li><a href="">shirts</a></li>
                    <li><a href="">pants</a></li>
                </menu>
            </nav>
            <main>
                
<?php }
function drawSignUp() { ?>
    <div id="credentials">
        <a href="">Register</a>
        <a href="">Login</a>
    </div>
<?php } 
//when it's ready, delete from previous comment until this one
function drawFooter() { ?>
            </main>

            <footer>
                <p>Our phone number: 000 000 000</p>
                <p>Our email: example@gmail.com</p>
                <h6>site made by</h6>
                <p>Alexandre Lopes</p>
                <p>Lucas Faria</p>
                <p>Rafael Campeão</p>
                <p>&copy; Vintage Lovers 2024<p>
            </footer>
        </body>
    </html>
<?php }

function drawHeaderLogin() { ?>
    <div class= "login" >
        <a href="../pages/register.php">Register</a>
        <a href="../pages/login.php">Login</a>
    </div>
<?php }

function drawLogout(Session $session){ ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="../pages/profile.php"><?=$session->getUserName()?></a>
        <button type="submit">Logout</button>
    </form>
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
