<?php

declare(strict_types=1);

require_once(__DIR__ . '/common.tpl.php');

function drawLogin(Session $session){
    //draws the login page main content
    ?>

<section class = "auth">
    <header>
        <h1>Login</h1>
    </header>

    <?php
        displayMessages($session);
    ?>
    
    <form action= "/../actions/action_login.php" method="post" class= "login" >
        <label>
            <p>Email:</p>
            <input type="email" name="email" required>
        </label>
        <label>
           <p> Password:</p>
            <input type = "password" name = "password" required>
        </label>
        <input type="submit" name = "login" value="Login">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>

    <footer>
        <p>If you haven't created an account yet, please register <a href="register.php">here</a></p>
    </footer>
</section>

<?php }

function drawSignup(Session $session){
    //draws the signup page main content
    ?>

    <section class = "auth">
        <header>
            <h1>Register</h1>
        </header>

        <?php
            displayMessages($session);
        ?>

        <form method="post" action = "/../actions/action_signup.php">
            <label>
                <p>Username:</p>
                <input type = "text" name = "username" required>
            </label>
            <label>
                <p>Name:</p>
                <input type = "text" name = "name" required>
            </label>
            <label>
                <p>Email:</p>
                <input type = "email" name = "email" required>
            </label>
            <label>
                <p>Password:</p>
                <input type = "password" name = "password" required>
            </label>
            <input type="submit" name = "register" value="Register">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>

        <footer>
            <p>If you already have an account, please login <a href="login.php">here</a></p>
        </footer>
        
    </section>

<?php }