<?php

    namespace models;

	use config\Database;


    class Employee extends Model{
        protected static $table = "employees";

        public function __construct(
            public int $employee_id,
			public ?string $first_name=null,
			public ?string $last_name=null,
			public ?string $email=null,
			public ?string $phone_number=null,
			public ?string $hire_date=null,
			public ?string $job_id=null,
			public ?float $salary=null,
			public ?float $commission_pct=null,
			public ?int $manager_id=null,
			public ?int $department_id=null
        ){}

		public function destroy(){
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
				$sql = "DELETE from $table where employee_id = ?";
				$stmt = $db->conn->prepare($sql);				
				$stmt->bind_param("i", $this->employee_id);
				$stmt->execute();
				if($stmt->affected_rows > 0){
					echo "Empleado eliminado";
				}
				else{
					echo "Error" . $stmt->error;
				}
				$db->conn->commit();
			}
			catch(\mysqli_sql_exception $e){
				if($db->conn){
					$db->conn->rollback();
					throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
				}				
			}
			finally{
				if($db->conn){
					$db->dbClose();
				}
				
			}
		}

		
        public function save(){
			error_reporting(E_ALL);

			try{
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

				$sql = "INSERT INTO $table(employee_id, first_name, last_name, email, phone_number, hire_date, job_id, salary, commission_pct, manager_id, department_id)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
					ON DUPLICATE KEY UPDATE
					first_name = VALUES(first_name),
					last_name = VALUES(last_name),
					email = VALUES(email),
					phone_number = VALUES(phone_number),
					hire_date = VALUES(hire_date),
					job_id = VALUES(job_id),
					salary = VALUES(salary),
					commission_pct = VALUES(commission_pct),
					manager_id = VALUES(manager_id),
					department_id = VALUES(department_id)";

				$stmt = $db->conn->prepare($sql);
				
				$stmt->bind_param(
					"issssssddii", 
					$this->employee_id, 
					$this->first_name, 
					$this->last_name, 
					$this->email, 
					$this->phone_number, 
					$this->hire_date, 
					$this->job_id, 
					$this->salary, 
					$this->commission_pct, 
					$this->manager_id, 
					$this->department_id	
				);
				$stmt->execute();
				$db->conn->commit();
			}
			catch(\mysqli_sql_exception $e){
				if($db->conn){
					$db->conn->rollback();
					throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
				}				
			}
			finally{
				if($db->conn){
					$db->dbClose();
				}
			}

        }

    }



?>