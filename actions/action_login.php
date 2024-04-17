<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/sessions.php');
    
    $session = new Session();

    require_once(__DIR__ . '/../database/database_connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    $user = User::getUserByPassword($db, $_POST['email'] , $_POST['password']);
  
    if($user){
        $session->setId($user->getID());
        $session->setUsername($user->getUsername());
        $session->addMessage('success', 'Login successful');

        //verifies if we can go back to the origin URL, otherwise we go back to the index
        $location = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '../pages/index.php';
        header('Location: ../pages/index.php' );

    } else{
        $session->addMessage('error', 'Wrong password!');
        header('Location: ../pages/login.php');

    }
    

?>