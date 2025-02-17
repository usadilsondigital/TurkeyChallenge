<?php
class Turkey {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addTurkey($name, $status, $size, $color, $gender) {
        $stmt = $this->conn->prepare("INSERT INTO turkeys (name, status, size, color, gender) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $status, $size, $color, $gender]);
    }

    public function getTurkeys() {
        $stmt = $this->conn->query("SELECT * FROM turkeys");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTurkey($id) {
        $stmt = $this->conn->prepare("SELECT * FROM turkeys WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTurkey($id, $name, $status, $size, $color, $gender) {
        $stmt = $this->conn->prepare("UPDATE turkeys SET name=?, status=?, size=?, color=?, gender=? WHERE id=?");
        return $stmt->execute([$name, $status, $size, $color, $gender, $id]);
    }

    public function deleteTurkey($id) {
        $stmt = $this->conn->prepare("DELETE FROM turkeys WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function generateReport() {
        $stmt = $this->conn->query("SELECT id, name, status FROM turkeys ORDER BY status");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Save a turkey
    public function saveTurkey($name, $status, $size, $color, $gender) {
        $stmt = $this->conn->prepare("INSERT INTO turkeys (name, status, size, color, gender) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $status, $size, $color, $gender]);
    }

    // Load all turkeys
    public function loadAllTurkeys() {
        return $this->conn->query("SELECT * FROM turkeys")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Load a single turkey
    public function loadTurkey($id) {
        $stmt = $this->conn->prepare("SELECT * FROM turkeys WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
