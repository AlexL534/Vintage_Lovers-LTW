<?php
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $db = getDatabaseConnection();

    $searchResults = User::searchUsers($db, $search);
    echo json_encode($searchResults);
} else {
    echo json_encode([]);
}
?>
