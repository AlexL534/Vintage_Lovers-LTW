<?php

declare(strict_types=1);

require_once(__DIR__ . '/common.tpl.php');

function drawLogin(Session $session){?>

<section id = "login">
    <header>
        <h1>Login<h2>
    </header>

    <?php
        displayMessages($session);

    ?>
    
    <form action= "../actions/action_login.php" method="post" class= "login" >
        <label>
            Email:
            <input type="email" name="email" required>
        </label>
        <label>
            Password:
            <input type = "password" name = "password" required>
        </label>
        <input type="submit" name = "login" value="Login">
    </form>

    <footer>
        <p>If you haven't created an account yet, please register <a href="register.php">here</a></p>
    </footer>
</section>

<?php }

function drawSignup2(Session $session){?>

    <section id = "signup">
        <header>
            <h1>Register</h1>
        </header>

        <?php
            displayMessages($session);
        ?>

        <form method="post" action = "../actions/action_signup.php">
            <label>
                Username:
                <input type = "text" name = "username" required>
            </label>
            <label>
                Name:
                <input type = "text" name = "name" required>
            </label>
            <label>
                Email:
                <input type = "email" name = "email" required>
            </label>
            <label>
                Password:
                <input type = "password" name = "password" required>
            </label>
            <input type="submit" name = "register" value="Register">
        </form>

        <footer>
            <p>If you already have an account, please login <a href="login.php">here</a></p>
        </footer>
        
    </section>

<?php }