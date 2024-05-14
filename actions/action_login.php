<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../database/database_connection.db.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    
    $session = new Session();

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['password'])) {
        $email = filter_var(strtolower($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        if (!$email) {
            $session->addMessage('error', 'Invalid email format');
            header('Location: /../pages/login.php');
            exit();
        }
    }
    else {
        $session->addMessage('error', 'Invalid request');
    header('Location: /../pages/login.php');
    exit();
    }
        
    $db = getDatabaseConnection();

    $user = User::getUserByEmail($db, $email);
  
    if($user && password_verify($password, $user->getPassword())){
        $session->setId($user->getID());
        $session->setUsername($user->getUsername());
        $session->addMessage('Success', 'Login successful');

        header('Location: ../pages/main_page.php' );
        exit();
    } else{
        $session->addMessage('error', 'Wrong email or password!');
        header('Location: ../pages/login.php');
        exit();
    }
?>