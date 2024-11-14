<?php
session_start(); // si ja existeix sessió, associa la sessió a l'actual
ob_start();  // necessari per a la redirecció de 'header()': resetea el buffer de salida

// Comprova si l'usuari ha iniciat la sessió
if (!isset($_SESSION['username'])) {  // si està definida amb un valor no null -> true
	// Si no es troba una sessió, cal treure l'usuari fora
	echo "<script>alert('Para acceder a esta área necesitas loguearte primero. Clica en Aceptar para ir al login'); window.location.href='iniciosesion.php';</script>";
	//header("Location: login.php");  // redirigeix a 'login'
	exit();  // garanteix que no s'executi més codi
}

ob_end_flush();  // necessari per a la redirecció de 'header()': envia la sortida enmagatzemada en el buffer
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Human Resource</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		.wrapper {
			width: 600px;
			margin: 0 auto;
		}

		table tr td:last-child {
			width: 120px;
		}
	</style>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</head>

<body>
	<div id="header">
		<h1>Employees</h1>
	</div>
	<div id="content">
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li>
					<ul> HR
						<li><a href="employees.php">Employees</a></li>
						<li><a href="departments.php">Departments</a></li>
						<li><a href="jobs.php">Jobs</a></li>
						<li><a href="locations.php">Locations</a></li>
						<li><a href="Promotions.php">Promotions</a></li>
					</ul>
				</li>
				<li>
					<ul> OE
						<li><a href="">Warehouses</a></li>
						<li><a href="">Categories</a></li>
						<li><a href="customers.php">Customers</a></li>
						<li><a href="">Products</a></li>
						<li><a href="">Orders</a></li>
						<li><a href="regions.php">Regions</a></li>
						<li><a href="countries.php">Countries</a></li>
					</ul>
				</li>
				<li><a href="logout.php">Cerrar sesión</a></li>
			</ul>
		</div>

		<div id="section">
			<?php
			require 'vendor/autoload.php';

			use Faker\Factory;
			use models\Job;
			use models\Department;

			$faker = Factory::create();
			$jobs = Job::all();
			$departments = Department::all();
			// var_dump($deparments);

			?>
			<h2>Datos para añadir nuevo Empleado</h2>
			<form action="InsertEmployee.php" method="POST">
				<label for="employee_id">ID Empleado:</label>
				<input type="number" name="employee_id" id="employee_id" required oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"><br><br>

				<label for="first_name">Nombre:</label>
				<input type="text" name="first_name" id="first_name" required maxlength="20"
					placeholder="<?php
									echo $faker->name ?>"><br><br>

				<label for="last_name">Apellidos:</label>
				<input type="text" name="last_name" id="last_name" required maxlength="25"
					placeholder="<?php
									echo $faker->lastname ?>"><br><br>

				<label for="email">Email:</label>
				<input type="email" name="email" id="email" maxlength="25"
					placeholder="<?php
									echo $faker->email ?>"><br><br>

				<label for="phone_number">Número de Teléfono:</label>
				<input type="text" name="phone_number" id="phone_number" maxlength="20"><br><br>

				<label for="hire_date">Fecha de Contratación:</label>
				<input type="date" name="hire_date" id="hire_date" value="2000-01-01"><br><br>

				<label for="job_id">Job ID:</label>
				<select name="job_id" id="job_id" required>
					<?php foreach ($jobs as $job) : ?>
						<option value="<?php echo htmlspecialchars($job->job_id); ?>"><?php echo htmlspecialchars($job->job_title); ?></option>
					<?php endforeach; ?>
					<!-- <option value="AD_PRES">Presidente</option>
					<option value="AD_VP">Vicepresidente</option>
					<option value="AD_ASST">Asistente</option>
					<option value="FI_MGR">Director Financiero</option>
					<option value="FI_ACCOUNT">Contable de Finanzas</option>
					<option value="AC_MGR">Director de Contabilidad</option>
					<option value="AC_ACCOUNT">Contable</option>
					<option value="IT_PROG">Programador</option>
					<option value="PU_MAN">Director de Compras</option>
					<option value="PU_CLERK">Empleado de Compras</option>
					<option value="ST_MAN">Director de Almacén</option>
					<option value="ST_CLERK">Empleado de Almacén</option>
					<option value="SH_CLERK">Empleado de Envíos</option>
					<option value="SA_REP">Representante de Ventas</option>
					<option value="SA_MAN">Director de Ventas</option>
					<option value="HR_REP">Representante de RRHH</option>
					<option value="PR_REP">Representante de RRPP</option>
					<option value="MK_MAN">Director de Marketing</option>
					<option value="MK_REP">Representante de Marketing</option> -->
				</select><br><br>

				<label for="salary">Salario:</label>
				<input type="number" name="salary" id="salary" step="0.01"oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8)"><br><br>

				<label for="commission_pct">Comisión (%):</label>
				<input type="number" name="commission_pct" id="commission_pct" step="0.01" oninput="if(this.value.length > 2) this.value = this.value.slice(0, 2)"><br><br>

				<label for="manager_id">ID Manager:</label>
				<select name="manager_id" id="manager_id">
					<option value="100">Steven King</option>
					<option value="101">Neena Kochhar</option>
					<option value="102">Lex De Haan</option>
					<option value="103">Alexander Hunold</option>
					<option value="108">Nancy Greenberg</option>
					<option value="114">Den Raphaely</option>
					<option value="120">Matthew Weiss</option>
					<option value="121">Adam Fripp</option>
					<option value="122">Payam Kaufling</option>
					<option value="123">Shanta Vollman</option>
					<option value="124">Kevin Mourgos</option>
					<option value="145">John Russell</option>
					<option value="146">Karen Partners</option>
					<option value="147">Alberto Errazuriz</option>
					<option value="148">Gerald Cambrault</option>
					<option value="149">Eleni Zlotkey</option>
					<option value="201">Michael Hartstein</option>
					<option value="205">Shelley Higgins</option>
				</select><br><br>

				<label for="department_id">ID Departamento:</label>
				<select name="department_id" id="department_id" required>
					<?php foreach ($departments as $department) : ?>
						<option value="<?php echo htmlspecialchars($department->department_id); ?>"><?php echo htmlspecialchars($department->department_name); ?></option>
					<?php endforeach; ?>
				</select><br><br>
					
					<!-- <option value="10">Administración</option>
					<option value="20">Contabilidad</option>
					<option value="30">RRHH</option>
					<option value="40">Ventas</option>
					<option value="50">Marketing</option>
					<option value="60">IT</option>
					<option value="70">Logística</option>
					<option value="80">Compras</option>
					<option value="90">Producción</option>
					<option value="100">Calidad</option>
					<option value="110">Mantenimiento</option> -->
				

				<input type="submit" value="Añadir Empleado">
			</form>
		</div>
	</div>

	<div id="footer">
		<p>(c) IES Emili Darder - 2022</p>
	</div>
</body>

</html>

<?php

use models\Employee;


function convertToNull($value)
{
	return $value === '' ? null : $value;
}

try {
	// Si el formulario ha sido enviado
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Obtener los valores del formulario
		$employee_id     = $_POST['employee_id'];
		$first_name      = $_POST['first_name'];
		$last_name       = $_POST['last_name'];
		$email           = $_POST['email'];
		$phone_number    = $_POST['phone_number'];
		$hire_date       = $_POST['hire_date'];
		$job_id          = $_POST['job_id'];
		$salary          = $_POST['salary'];
		$commission_pct  = $_POST['commission_pct'];
		$manager_id      = $_POST['manager_id'];
		$department_id   = $_POST['department_id'];

		// Crear instancia de Employee
		$employee = new Employee(
			$employee_id,
			$first_name,
			$last_name,
			convertToNull($email),
			convertToNull($phone_number),
			convertToNull($hire_date),
			$job_id,
			convertToNull($salary),
			convertToNull($commission_pct),
			$manager_id,
			$department_id
		);

		// Guardar el empleado en la base de datos
		$employee->save();  // INSERT / UPDATE
		echo "<script>alert('Employee creado con éxito.'); window.location.href='employees.php';</script>";
	}
} catch (\Exception $e) {
	echo "Se ha producido el siguiente error:" . "<br>" . $e->getMessage();
}

?>