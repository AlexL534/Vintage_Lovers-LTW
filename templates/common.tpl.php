<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/sessions.php');

function drawHeader(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/layout.css">
        <head>
        <body>
            <header>
                   <a href="../pages/main_page.php"><img src="../docs/Logo3.png" alt= "logo" id = "logo"></a>
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

function drawFooter() { ?>
            </main>

            <footer>
                <div id ="contacts">
                    <p>Our phone number: 000 000 000</p>
                    <p>Our emial: example@gmail.com</p>
                </div>
                <div id = "authors">
                    <h6>site made by</h6>
                    <p>Alexandre Lopes</p>
                    <p>Lucas Faria</p>
                    <p>Rafael Campeão</p>
                </div>
                <p>&copy; Vintage Lovers 2024<p>
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
