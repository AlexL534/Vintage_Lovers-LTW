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
    
    <form action= "../action_login.php" method="post" class= "login" >
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
        <p>If you don't have already an account please register <a href="signup.php">here</a></p>
    </footer>
</section>

<?php }

function drawSignup(){?>

    <section id = "signup">
        <header>
            <h1>Register</h1>
        </header>

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
            <label>
        </form>

        <footer>
            <p>If you already already have an account please do the login <a href="login.php">here</a></p>
        </footer>
        
    </section>

<?php }