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
