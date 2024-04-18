<?php

declare(strict_types = 1);

function drawProfile(PDO $db, User $user){
    //draws the user profile (info and user/admin options)
    ?>
    
    <section class = "profile">
        <header>
            <h1>Profile</h1>
        </header>
        <?php drawUserInfo($db, $user); ?>
    </section>
<?php }

function drawUserInfo(PDO $db, User $user){ 
    //draws the user info 
    ?>
    <article id="userInfo">
        <!-- Still need to put the image here -->
        <p>Name</p>
        <p><?= $user->getName(); ?></p>
        <p>Username</p>
        <p><?= $user->getUsername(); ?></p>
        <p>Email</p>
        <p><?= $user->getEmail(); ?></p>
        <p>Number of Owned itens</p>
        <p><?= count($user->getUserOwnedItens($db)); ?></p>
    </article>
<?php }

?>