<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/sessions.php');

function drawHeader(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link href="../css/generalStyle.css" rel="stylesheet">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/layout.css">
        <head>
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
            <?php drawSignUp()?>
            <nav id= "menu">
                <input type="checkbox" id="menu_button"> 
                <menu>
                    <li><a href="">Shoes</a></li>
                    <li><a href="">Shirts</a></li>
                    <li><a href="">Pants</a></li>
                    <li>All</li>
                </menu>
            </nav>
            <main>
                
    <?php }

function drawFooter() { ?>
            </main>

            <footer>
                <p>Our phone number: 000 000 000</p>
                <p>Our emial: example@gmail.com</p>
                <h6>site made by</h6>
                <p>Alexandre Lopes</p>
                <p>Lucas Faria</p>
                <p>Rafael Campeão</p>
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
