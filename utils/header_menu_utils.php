<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/category.class.php');

function getCategoriesForMenu() : array{
    $db = getDatabaseConnection();
    $categories = Category::getCategoriesLimit($db, 3);
    return $categories;
}