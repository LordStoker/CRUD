<?php
    namespace models;
    use config\Database;

    abstract class Model{
        public static function all(){
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
            try{
                $sql = "select * from $table";
                $result = $db->conn->query($sql);

                $rows = [];
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $fila = new static( ...array_values($row));

                        $rows[] = $fila;
                    }
                }
            }
            catch(\mysqli_sql_exception $e){
                throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
            }
            finally{
                if($db->conn){
                    $db->dbClose();
                }
            }
            return $rows;
        }



    }




?>