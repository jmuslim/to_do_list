<?php
include_once 'todolist_db.php';

class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $task;
    public $is_completed;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET task=:task";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":task", $this->task);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT id, task, is_completed, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET task = :task, is_completed = :is_completed WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":task", $this->task);
        $stmt->bindParam(":is_completed", $this->is_completed);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
