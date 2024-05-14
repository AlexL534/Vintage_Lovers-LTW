<?php
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/database_connection.db.php');

if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : ''; 
    $userType = isset($_GET['userType']) ? htmlspecialchars(trim($_GET['userType'])) : 'all'; 
    
    if (!in_array($userType, ['all', 'admin', 'normal'])) {
        echo json_encode(['error' => 'Invalid user type']);
        exit;
    }
    
    $db = getDatabaseConnection();

    $searchResults = User::searchUsers($db, $search, $userType);
    echo json_encode($searchResults);
} else {
    echo json_encode([]);
}
?>
