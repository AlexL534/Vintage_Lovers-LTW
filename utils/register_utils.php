<?php
declare(strict_types=1);

function hasEnoughLen(string $password) : bool{
    //verify if the password has enough len
    
    return strlen($password) < 8;
}

function hasUpperCaseCharacters(string $password){
    //verify if the password has upper case characters

    return preg_match('/[A-Z]/', $password);
}

function hasNumbers(string $password){
    //verify if the password has numbers

    return preg_match('/\d/', $password);
}

function isEmail(string $email){
    //verify if the inserted string is an email

    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i';
    return preg_match($pattern, $email);
}