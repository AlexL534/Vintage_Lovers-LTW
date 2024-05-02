<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../classes/session.class.php');
    
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.db.php');
    require_once(__DIR__ . '/../classes/user.class.php');

    $db = getDatabaseConnection();
    $password = $_POST['password'];
    $email = strtolower($_POST['email']);


    $user = User::getUserByEmail($db, $email);
  
    if($user && password_verify($password, $user->getPassword())){
        $session->setId($user->getID());
        $session->setUsername($user->getUsername());
        $session->addMessage('success', 'Login successful');

        header('Location: ../pages/main_page.php' );

    } else{
        $session->addMessage('error', 'Wrong password!');
        header('Location: ../pages/login.php');

    }
    

?>