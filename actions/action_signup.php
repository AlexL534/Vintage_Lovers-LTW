<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/sessions.php');

$session = new Session();

require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');

$db = getDatabaseConnection();

if(User::emailExists($db, $_POST['email'])){
    //checks if the email already exists
    $session->addMessage("error", "Email already exists");
    header('Location: ../pages/register.php');
}

else if(User::usernameExists($db, $_POST['username'])){
    //checks if the username already exists
    $session->addMessage("error", "Username already exists");
    header('Location: ../pages/register.php');
}

else{
    User::insertNewUser($db, $_POST['name'], $_POST['username'], $_POST['email'], $_POST['password']);

    //check if the user was inserted correctly  and executes the login
    $user = User::getUserByPassword($db, $_POST['email'] , $_POST['password']);
  
    if($user){
        $session->setId($user->getID());
        $session->setUsername($user->getUsername());
        $session->addMessage('success', 'Login successful');

        //verifies if we can go back to the origin URL, otherwise we go back to the index
        $location = isset($_SESSION['previousPage'])? $_SESSION['previousPage'] : '../pages/index.php';
        header("Location: $location" );

    } else{
        $session->addMessage('error', 'Something went wrong. Try again!');
        header('Location: ../pages/register.php');
    }
}