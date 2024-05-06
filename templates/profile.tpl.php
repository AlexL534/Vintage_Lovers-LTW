<?php

declare(strict_types = 1);
require_once(__DIR__ . '/../classes/product.class.php');

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

function drawEditProfile(PDO $db, User $user, Session $session){
    ?>

    <section class = "editProfile">
        <header>
            <h1>Edit Your Profile</h1>
        </header>

        <?php
        displayMessages($session);
        ?>

        <form action= "../actions/action_edit_profile.php" method="post" >
            <label>
                <p>Username:</p>
                <input type = "text" name = "username" placeholder= <?= htmlentities($user->getUsername())?>>
            </label>
            <label>
                <p>Name:</p>
                <input type = "text" name = "name" placeholder= <?= htmlentities($user->getName())?> >
            </label>
            <label>
            <p> Password:</p>
                <input type = "password" name = "password" >
            </label>
            <input type="submit" name = "login" value="Update">
        </form>


    </section>
<?php }

function drawUserInfo(PDO $db, User $user){ 
    //draws the user info 
    ?>
    <article id="userInfo">
        <!-- Still need to put the image here -->

        <table>
            <tr><td>Name: </td><td><?= htmlentities($user->getName()); ?></td></tr>
            <tr><td>Username:</td> <td><?= htmlentities($user->getUsername()); ?></td></tr>
            <tr><td>Email:</td> <td><?= htmlentities($user->getEmail()); ?></td></tr>
            <tr><td>Number of owned items:</td> <td><?= count($user->getUserOwnedItems($db)); ?></td></tr>
        </table>
    </article>
<?php }

function drawUserOptions(){
    //draws the user/seller options
    ?>
    <article class = "profileOptions" id="userOptions">
        <ul>
            <li><a href= "../pages/edit_profile.php"><p>Update Profile</p></a></li>
            <li><a><p>Wishlist</p></a></li>
            <li><a href="../pages/seller_product_list.php"><p>Manage owned Products</p></a></li>
            <li><a href="../pages/seller_add_product.php"><p>List a new Procuct</p></a></li>
            <li><a><p>Sold Products</p></a></li>
            <li id="logoutButton"><a href = "../actions/action_logout.php"><p>Logout</p></a></li>
        </ul>
    </article>
<?php }

function drawAdminOptions(){
    //draws the admin options
    ?>
        <h2>Admin Options</h2>
    <article class = "profileOptions" id="adminOptions">
        <ul>
            <li><a href="../pages/admin_filters.php"><p>Add information to the system</p></a></li>
            <li><a href="../pages/admin_manage_user.php"><p>Manage users</p></a></li>
            <li><a href="../pages/admin_delete_product.php"><p>Remove a product</p></a></li>
        </ul> 
    </article>
<?php }
