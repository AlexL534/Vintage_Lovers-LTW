<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');
function addFilterToDatabase(string $type, string $name, string $description = '') {
    $validTypes = ['category', 'size', 'condition', 'color', 'brand'];
    if (!in_array($type, $validTypes)) {
        throw new InvalidArgumentException("Invalid filter type");
    }
    try {
        $db = getDatabaseConnection();
        $stmt = null;
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
        }

        if (!$stmt) {
            throw new RuntimeException("Failed to prepare SQL statement");
        }

        $stmt->bindParam(':name', $name);
        if ($type === 'category' || $type === 'condition') {
            $stmt->bindParam(':description', $description);
        }   

        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Database error: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    if ($type !== null && $type !== '') {
        try {
            if (addFilterToDatabase($type, $name, $description)) {
                echo "The $type $name was added successfully.";
                header("Location: admin_specific_filter.php?type=$type");
                exit();
            } else {
                echo "Failed to add $type $name.";
            }
        } catch (InvalidArgumentException $e) {
            echo "Error: " . $e->getMessage();
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Filter type is missing or empty.";
    }
} else {
    echo "Invalid request method";
}
?>
