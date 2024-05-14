<?php

declare(strict_types=1);

require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();

require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../utils/register_utils.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/register.php');
    exit();
}

$db = getDatabaseConnection();
$password = $_POST['password'];
$email = strtolower($_POST['email']);

if(hasEnoughLen($password)){
    //checks if the lenght of the password is enough
    $session->addMessage("error", "The password needs to have 8 characters at least");
    header('Location: /../pages/register.php');
}

else if(hasUpperCaseCharacters($password) != 1){
    //checks the strenght of the password by checking if it has Upper case letters
    $session->addMessage("error", "The password doesn't have Upper case characters");
    header('Location: /../pages/register.php');
}

else if(hasNumbers($password) != 1){
    //checks the strenght of the password by checking if it has numbers
    $session->addMessage("error", "The password doesn't have numbers");
    header('Location: /../pages/register.php');
}

else if(isEmail($email) != 1){
    //checks if the email is valid
    $session->addMessage("error", "Insert a valid email");
    header('Location: /../pages/register.php');
}

else if(User::emailExists($db, $email)){
    //checks if the email already exists
    $session->addMessage("error", "Email already exists");
    header('Location: /../pages/register.php');
}

else if(User::usernameExists($db, $_POST['username'])){
    //checks if the username already exists
    $session->addMessage("error", "Username already exists");
    header('Location: /../pages/register.php');
}

else{

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    User::insertNewUser($db, $_POST['name'], $_POST['username'], $email, $hashedPassword);

    //check if the user was inserted correctly  and executes the login
    $user = User::getUserByPassword($db, $email , $hashedPassword);
  
    if($user){
        $session->setId($user->getID());
        $session->setUsername($user->getUsername());
        $session->addMessage('success', 'Login successful');
        
        header("Location: /../pages/main_page.php" );

    } else{
        $session->addMessage('error', 'Something went wrong. Try again!');
        header('Location: /../pages/register.php');
    }
}