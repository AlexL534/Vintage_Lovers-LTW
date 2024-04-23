<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');
error_log('1');
function addFilterToDatabase($type, $name, $description = '') {
    try {
        $db = getDatabaseConnection();
        switch ($type) {
            case 'category':
                $stmt = $db->prepare("INSERT INTO CATEGORY (name, description) VALUES (:name, :description)");
                break;
            case 'size':
                $stmt = $db->prepare("INSERT INTO SIZE (name) VALUES (:name)");
                break;
            case 'condition':
                $stmt = $db->prepare("INSERT INTO CONDITION (name, description) VALUES (:name, :description)");
                break;
            case 'color':
                $stmt = $db->prepare("INSERT INTO COLOR (name) VALUES (:name)");
                break;
            case 'brand':
                $stmt = $db->prepare("INSERT INTO BRAND (name) VALUES (:name)");
                break;
            default:
                throw new Exception("Invalid filter type");
        }

        $stmt->bindParam(':name', $name);
        if ($type === 'category' || $type === 'condition') {
            $stmt->bindParam(':description', $description);
        }   

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        throw new Exception("Database error: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $type = $_POST['type']; 

    try {
        if (addFilterToDatabase($type, $name, $description)) {
            echo "The " . $type . ' ' . $name . ' was added.    ';
            header("Location: admin_specific_filter.php?type=".$type);
            exit();
        } else {
            echo "Failed to add " . $type . ' ' . $name;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>
