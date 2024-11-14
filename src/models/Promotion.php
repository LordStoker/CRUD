<?php

namespace models;

use config\Database;

class Promotion extends Model {
    protected static $table = "promotions";

    public function __construct(
        public int $promotion_id,
        public ?string $promo_name = null
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

            $sql = "INSERT INTO $table(promotion_id, promo_name)
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE
                    promotion_id = VALUES(promotion_id),
                    promo_name = VALUES(promo_name)";

            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("is", $this->promotion_id, $this->promo_name);
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
            $sql = "DELETE FROM $table WHERE promotion_id = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("i", $this->promotion_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Promotion eliminada con éxito";
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
