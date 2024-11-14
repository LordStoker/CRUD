<?php

    namespace config;
    
    class Database{
        public $conn;
        public function __construct(private string $host, private $port, private $database, private $username, private $password){

        }
        public static function loadConfig($fitxer) : array{
            $config = [];
            // Verifiquem que el fitxer existeix
            if (file_exists($fitxer)) {
                // Llegim el fitxer línia per línia ignora espais i línies buides, tabs, etc
                $linies = file($fitxer, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                 // Recórrer cada línia del fitxer
                 foreach ($linies as $linia) {
                    // Comprovam si la línia és un comentari
                    $linia = trim($linia);  // netejam la línia d'espais
                    if (strpos(trim($linia), '#') !== 0) {
                        list($clau, $valor) = explode('=', $linia, 2);
                        $config[trim($clau)] = trim($valor); // Emmagatzemam un element 'clau' i 'valor' a l'array associatiu
                    }
                }
                return $config;
            } else {
                die("El fitxer de configuració no existeix.");
            }
        }

        public function dbConnect(){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            try{
                $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
                $this->conn->autocommit(false);
            }
            catch(\mysqli_sql_exception $e){
                throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
            }

        }
        public function dbClose(){
            if($this->conn){
                $this->conn->close();
                
            }
        }
        
    }

?>