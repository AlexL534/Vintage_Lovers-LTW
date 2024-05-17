<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');

class FilterType {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addFilterType(string $table, array $data): bool {
        try{
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removeFilterType($filter_type, $filter_name) {
        error_log('1');
        try {
            $tableName = strtoupper($filter_type);
            $query = "DELETE FROM $tableName WHERE name = :filter_name";
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':filter_name', $filter_name, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                return true;
            } else {
                print_r($stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }    
}
?>
