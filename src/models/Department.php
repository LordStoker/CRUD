<?php

namespace models;

use config\Database;

class Department extends Model {
    protected static $table = "departments";

    public function __construct(
        public int $department_id,
        public ?string $department_name = null,
        public ?int $manager_id = null,
        public ?int $location_id = null
    ) {}

    public function save() {
        try {
            $config = Database::loadConfig("__DIR__/../conf.db");
            $db = new Database(
                $config["DB_HOST"],
                $config["DB_PORT"],
                $config["DB_DATABASE"],
                $config["DB_USERNAME"],
                $config["DB_PASSWORD"]
            );  
            $db->dbConnect();  
            $table = static::$table;

            $sql = "INSERT INTO $table(department_id, department_name, manager_id, location_id)
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    department_name = VALUES(department_name),
                    manager_id = VALUES(manager_id),
                    location_id = VALUES(location_id)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("isii", $this->department_id, $this->department_name, $this->manager_id, $this->location_id);
            $stmt->execute();
            $db->conn->commit();
        }
        catch(\mysqli_sql_exception $e) {
            if ($db->conn) {
                $db->conn->rollback();
                throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
            }               
        }
        finally {
            if ($db->conn) {
                $db->dbClose();
            }
        }
    }

    public function destroy() {
        $config = Database::loadConfig("__DIR__/../conf.db");
        $db = new Database(
            $config["DB_HOST"],
            $config["DB_PORT"],
            $config["DB_DATABASE"],
            $config["DB_USERNAME"],
            $config["DB_PASSWORD"]
        );

        $db->dbConnect();
        $table = static::$table;

        try {
            $sql = "DELETE FROM $table WHERE department_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("i", $this->department_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Department eliminado con éxito";
            } else {
                echo "Error: " . $stmt->error;
            }
            $db->conn->commit();
        }
        catch(\mysqli_sql_exception $e) {
            if ($db->conn) {
                $db->conn->rollback();
                throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
            }               
        }
        finally {
            if ($db->conn) {
                $db->dbClose();
            }
        }
    }
}
?>
