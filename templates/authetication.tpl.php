<?php

function draw_login(){?>

<section id = "login">
    <header>
        <h1>Login<h2>
    </header>

    <form method="post" action="../actions/action_login.php">
        <label>
            Email:
            <input type="text" id="email" name="email" required>
        </label>
        <label>
            Password:
            <input type = "password" id = "password" name = "password" required>
        </label>
        <input type = "submit" value= "Login">
    </form>

    <footer>
        <p>If you don't have already an account please register <a href="signup.php">here</a></p>
    </footer>
</section>

<?php }

function draw_signup(){?>

    <section id = "signup">
        <header>
            <h1>Register</h1>
        </header>

        <form method="post" action = "../actions/action_signup.php">
            <label>
                Username:
                <input type = "text" id="username_SU" name = "username" required>
            </label>
            <label>
                Name:
                <input type = "text" id= "name_SU" name = "name" required>
            </label>
            <label>
                Email:
                <input type = "email" id= "email_SU" name = "email" required>
            </label>
            <label>
                Password:
                <input type = "password" id = "password_SU" name = "password" required>
            <label>
        </form>

        <footer>
            <p>If you already already have an account please do the login <a href="login.php">here</a></p>
        </footer>
        
    </section>

<?php }