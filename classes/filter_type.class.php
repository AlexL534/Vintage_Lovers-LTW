<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/database_connection.db.php');

class FilterType {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addFilterType(string $table, array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(array_values($data));
    }
}
?>
