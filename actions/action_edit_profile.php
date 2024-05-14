<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../utils/register_utils.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();

$userId = $session->getId();
$db = getDatabaseConnection();
$hasError = false;

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST"){
    echo "This is not a post request";
}

if(isset($_POST['username']) && $_POST['username'] !== "" ){
    $username = $_POST['username'];

    echo $username;

    if(User::usernameExists($db, $username)){
        $hasError = true;
        $session->addMessage("error", "Username already exists");
        header('Location: ../pages/edit_profile.php');
    }

    else if(User::updateUsername($db, $userId, $username) === false){
        $session->addMessage("error", "Could not update the username. Database error");
        header('Location: ../pages/edit_profile.php');
    }

}

if(isset($_POST["name"])  && $_POST["name"] !== ""){
    $name = $_POST["name"];

    if(User::updateName($db, $userId, $name) === false){
        $hasError = true;
        $session->addMessage("error", "Could not update the name. Database error");
        header('Location: ../pages/edit_profile.php');
    }
}

if(isset($_POST["password"])  && $_POST["password"] !== ""){
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(hasEnoughLen($password)){
        //checks if the lenght of the password is enough
        $hasError = true;
        $session->addMessage("error", "The password needs to have 8 characters at least");
        header('Location: ../pages/edit_profile.php');
    }
    
    else if(hasUpperCaseCharacters($password) != 1){
        //checks the strenght of the password by checking if it has Upper case letters
        $hasError = true;
        $session->addMessage("error", "The password doesn't have Upper case characters");
        header('Location: ../pages/edit_profile.php');
    }
    
    else if(hasNumbers($password) != 1){
        //checks the strenght of the password by checking if it has numbers
        $hasError = true;
        $session->addMessage("error", "The password doesn't have numbers");
        header('Location: ../pages/edit_profile.php');
    }


    else if(User::updatePassword($db, $userId, $hashedPassword) === false){
        //updates the password
        $hasError = true;
        $session->addMessage("error", "Could not update the password. Database error");
        header('Location: ../pages/edit_profile.php');
    }
}

if(!$hasError){
    $session->addMessage('success', 'Update successful');
    header('Location: ../pages/profile.php');
}