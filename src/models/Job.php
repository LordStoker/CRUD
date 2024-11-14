<?php

namespace models;

use config\Database;

class Job extends Model {
    protected static $table = "jobs";

    public function __construct(
        public string $job_id,
        public ?string $job_title = null,
        public ?int $min_salary = null,
        public ?int $max_salary = null
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

            $sql = "INSERT INTO $table(job_id, job_title, min_salary, max_salary)
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    job_id = VALUES(job_id),
                    job_title = VALUES(job_title),
                    min_salary = VALUES(min_salary),
                    max_salary = VALUES(max_salary)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("ssdd", $this->job_id, $this->job_title, $this->min_salary, $this->max_salary);
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
            $sql = "DELETE FROM $table WHERE job_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("s", $this->job_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Job eliminado con éxito";
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