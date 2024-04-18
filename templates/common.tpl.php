<?php 


function drawHeader() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Vintage Lovers </title>
            <meta charset="utf-8">
            <link href="../css/generalStyle.css" rel="stylesheet">
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

function drawSignUp() { ?>
    <div id="credentials">
        <a href="">Register</a>
        <a href="">Login</a>
    </div>
<?php } 