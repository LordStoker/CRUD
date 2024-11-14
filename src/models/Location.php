<?php

namespace models;

use config\Database;

class Location extends Model {
    protected static $table = "locations";

    public function __construct(
        public int $location_id,
        public ?string $street_address = null,
        public ?string $postal_code = null,
        public ?string $city = null, 
        public ?string $state_province = null,
        public ?string $country_id = null
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

            $sql = "INSERT INTO $table(location_id, street_address, postal_code, city, state_province, country_id)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    location_id = VALUES(location_id),
                    street_address = VALUES(street_address),
                    postal_code = VALUES(postal_code),
                    city = VALUES(city),
                    state_province = VALUES(state_province),
                    country_id = VALUES(country_id)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("isssss", $this->location_id, $this->street_address, $this->postal_code, $this->city, $this->state_province, $this->country_id);
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
            $sql = "DELETE FROM $table WHERE location_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("i", $this->location_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Location eliminada con éxito";
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