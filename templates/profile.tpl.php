<?php

declare(strict_types = 1);

function drawProfile(PDO $db, User $user){
    //draws the user profile (info and user/admin options)
    ?>
    
    <section class = "profile">
        <header>
            <h1>Profile</h1>
        </header>
        <?php 
            drawUserInfo($db, $user);
            drawUserOptions();
            if($user->getIsAdmin() == 1){
                drawAdminOptions(); 
            }
        ?>
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

function drawUserOptions(){
    //draws the user/seller options
    ?>
    <article id="userOptions">
        <ul>
            <li><a href = "../actions/action_logout.php" >Logout</a></li>
            <li><a>Update Profile</a></li>
            <li><a>Manage owned Products</a></li>
            <li><a>List a new Procuct</a></li>
            <li><a>Sold Products</a></li>
        </ul>
    </article>
<?php }

function drawAdminOptions(){
    //draws the admin options
    ?>
    <article id="adminOptions">
        <ul>
            <li><a>Add information to the system</a></li>
            <li><a>Remove user</a></li>
            <li><a>Remove a product</a></li>
            <li><a>Promote user to admin</a></li>
        </ul> 
    </article>
<?php }
?>