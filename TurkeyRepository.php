<?php
class TurkeyRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addTurkey($name, $status, $size, $color, $gender) {
        $stmt = $this->db->prepare("INSERT INTO turkeys (name, status, size, color, gender) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $status, $size, $color, $gender]);
    }

    public function getAllTurkeys() {
        $stmt = $this->db->query("SELECT * FROM turkeys");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTurkeyById($id) {
        $stmt = $this->db->prepare("SELECT * FROM turkeys WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTurkey($id, $name, $status, $size, $color, $gender) {
        $stmt = $this->db->prepare("UPDATE turkeys SET name=?, status=?, size=?, color=?, gender=? WHERE id=?");
        return $stmt->execute([$name, $status, $size, $color, $gender, $id]);
    }

    public function deleteTurkey($id) {
        $stmt = $this->db->prepare("DELETE FROM turkeys WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function getAllTurkeysOrder() {
        $stmt = $this->db->query("SELECT * FROM turkeys ORDER BY status");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
