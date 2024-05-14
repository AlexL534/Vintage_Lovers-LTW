<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');
require_once(__DIR__ . '/../classes/filter_type.class.php');
require_once(__DIR__ . '/../classes/session.class.php');

$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $session->addMessage('error', 'Suspicious activity found');
    header('Location: /../pages/main_page.php');
    exit();
}

if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['add'])) {
    //continues only if everything is set
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
            break;
        case 'size':
            $table = 'size';
            break;
        case 'condition':
            $table = 'condition';
            break;
        case 'color':
            $table = 'color';
            break;
        case 'brand':
            $table = 'brand';
            break;
        default:
            echo "Invalid filter type.";
            exit();
    }

    $filterTypeHandler = new FilterType($db);

    $data = ['name' => $name];
    if ($description) {
        $data['description'] = $description;
    }

    if ($filterTypeHandler->addFilterType($table, $data)) {
        header("Location: ../pages/admin_specific_filter.php?type=$table");
        exit();
    } else {
        echo "Error: Unable to add filter.";
    }
} else {
    echo "All fields are required.";
}
?>