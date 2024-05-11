<?php
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

// Check if the search query parameter is set
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $db = getDatabaseConnection();

    // Call the static method to search users in the database
    $searchResults = User::searchUsers($db, $search);

    // Output the search results in JSON format
    header('Content-Type: application/json');
    echo json_encode($searchResults);
} else {
    // If the search query parameter is not set, return an empty array
    echo json_encode([]);
}
?>
