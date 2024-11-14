<?php

namespace models;

use config\Database;

class Country extends Model {
    protected static $table = "countries";

    public function __construct(
        public string $country_id,
        public ?string $country_name = null,
        public ?int $region_id = null
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

            $sql = "INSERT INTO $table(country_id, country_name, region_id)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    country_name = VALUES(country_name),
                    region_id = VALUES(region_id)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("ssi", $this->country_id, $this->country_name, $this->region_id);
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
            $sql = "DELETE FROM $table WHERE country_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("s", $this->country_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Country eliminado con éxito";
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
