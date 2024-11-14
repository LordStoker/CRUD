<?php

namespace models;

use config\Database;

class Region extends Model {
    protected static $table = "regions";

    public function __construct(
        public int $region_id,
        public ?string $region_name = null
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

            $sql = "INSERT INTO $table(region_id, region_name)
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE
                    region_name = VALUES(region_name)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("is", $this->region_id, $this->region_name);
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
            $sql = "DELETE FROM $table WHERE region_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("i", $this->region_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Region eliminada con éxito";
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
