<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['add'])) {
    $db = getDatabaseConnection();
    $name = $_POST['name'];
    $filterType = isset($_POST['filter_type']) ? $_POST['filter_type'] : '';

    $description = '';
    if ($filterType === 'category' || $filterType === 'condition') {
        $description = isset($_POST['description']) ? $_POST['description'] : '';
    }

    switch ($filterType) {
        case 'category':
            $table = 'category';
            $columns = 'name';
            break;
        case 'size':
            $table = 'size';
            $columns = 'name';
            break;
        case 'condition':
            $table = 'condition';
            $columns = 'name, description';
            break;
        case 'color':
            $table = 'color';
            $columns = 'name';
            break;
        case 'brand':
            $table = 'brand';
            $columns = 'name';
            break;
        default:
            echo "Invalid filter type.";
            exit();
    }

    $sql = "INSERT INTO $table ($columns) VALUES (:name";
    if ($description) {
        $sql .= ", :description";
    }
    $sql .= ")";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':name', $name);
    if ($description) {
        $stmt->bindParam(':description', $description);
    }

    if ($stmt->execute()) {
        header("Location: ../pages/admin_specific_filter.php?type=$table");
        exit();
    } else {
        echo "Error: Unable to add filter.";
    }
} else {
    echo "All fields are required.";
}
?>