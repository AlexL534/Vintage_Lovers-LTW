<?php 


function drawHeader() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
        <head>
        <body>
            <header>
                   <img src="../docs/Logo3.png" alt= "logo">
                   <form>
                        <input type="search" name="search" placeholder="type">
                    <form>
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

function drawFooter() { ?>
            </main>

            <footer>
                <p>&copy; Vintage Lovers 2024<p>
            </footer>
        </body>
    <html>
<?php }

function drawSignUp() { ?>
    <div id="credentials">
        <a href="">Register</a>
        <a href="">Login</a>
    </div>
<?php } 