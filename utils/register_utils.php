<?php
declare(strict_types=1);

function hasEnoughLen(string $password) : bool{
    return strlen($password) < 8;
}

function hasUpperCaseCharacters(string $password){
    return preg_match('/[A-Z]/', $password);
}

function hasNumbers(string $password){
    return preg_match('/\d/', $password);
}

function isEmail(string $email){
    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i';
    return preg_match($pattern, $email);
}