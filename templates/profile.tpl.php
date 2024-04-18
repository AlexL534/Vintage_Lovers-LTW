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
        <ul>
            <li>Name: <?= $user->getName(); ?></li>
            <li>Username: <?= $user->getUsername(); ?></li>
            <li>Email: <?= $user->getEmail(); ?></li>
            <li>User type: <?php 
                $user->getIsAdmin() == 1 ? $type = "Admin" :  $type = "Seller" ;
                echo $type;
            ?></li>
            <li>Number of Owned itens: <?= count($user->getUserOwnedItens($db)); ?></li>

        </ul>
    </article>
<?php }

function drawOptions(){
    //draws the user/seller options
    ?>
    <article
<?php }
?>