<?php //NOT WORKING NOT WORKING NOT WORKING NOT WORKING NOT WORKING NOT WORKING NOT WORKING NOT WORKING NOW WORKING NOW WORK
require_once(__DIR__ . '/../database_connection.db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $type = $_POST['type']; 

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
                echo "Invalid filter type";
                exit(); // Stop execution
        }

        $stmt->bindParam(':name', $name);
        if ($type === 'category' || $type === 'condition') {
            $stmt->bindParam(':description', $description);
        }

        if ($stmt->execute()) {
            echo "The " . $type . ' ' . $name . ' was added.    ';
            header("Location: admin_specific_filter.php?type=".$type);
            exit();
        }   
        else {
            echo "Failed to add " . $type . ' ' . $name;
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>
