<?php
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/filter_type.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove'])) {

    $filter_name = filter_input(INPUT_POST, 'filter_name', FILTER_SANITIZE_STRING);
    $filter_type = filter_input(INPUT_POST, 'filter_type', FILTER_SANITIZE_STRING);

    $allowedTypes = array('category', 'size', 'condition', 'color', 'brand');
    if (!in_array($filter_type, $allowedTypes)) {
        echo "Invalid filter type specified";
        exit;
    }

    $db = getDatabaseConnection();
    $filterTypeHandler = new FilterType($db);

    if ($filterTypeHandler->removeFilterType($filter_type, $filter_name)) {
        header("Location: ../pages/admin_remove_specific_filter.php?type=$filter_type");
        exit();
    } else {
        echo "Error: Unable to remove filter.";
    }
} else {
    echo "Invalid request.";
}
?>
