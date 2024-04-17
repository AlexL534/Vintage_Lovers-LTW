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
                   <img src="../docs/Logo3.png" alt= "logo" id = "logo">
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
                    <li>shoes</li>
                    <li>shirts</li>
                    <li>pants</li>
                </menu>
            </nav>
            <main>
    <?php }

function drawFooter() { ?>
            </main>

            <footer>
                <p>&copy; Vintage Lovers 2024<p>
            </footer>
        </body>
    <html>
<?php }

function drawHeaderLogin() { ?>
    <div id= "headerLog" >
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
      <?php foreach ($session->getMessages() as $messsage) { ?>

        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>

      <?php } ?>
    </section>
<?php }
