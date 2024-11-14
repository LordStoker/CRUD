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
		<h1>Jobs</h1>
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

			$faker = Factory::create();
			?>
			<h2>Datos para añadir nuevo Job</h2>
			<form action="InsertJob.php" method="POST">
				<label for="job_id">Job ID:</label>
				<input type="text" name="job_id" id="job_id" required maxlength="10"><br><br>

				<label for="job_title">Job Title:</label>
				<input type="text" name="job_title" id="job_title" required maxlength="35"
					placeholder="<?php
									echo $faker->jobTitle ?>"><br><br>

				<label for="min_salary">Min Salary:</label>
				<input type="number" name="min_salary" id="min_salary" oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)"><br><br>

				<label for="max_salary">Max Salary:</label>
				<input type="number" name="max_salary" id="max_salary" oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)"><br><br>


				<input type="submit" value="Añadir Job">
			</form>
		</div>
	</div>

	<div id="footer">
		<p>(c) IES Emili Darder - 2022</p>
	</div>
</body>

</html>

<?php

use models\Job;

require_once 'vendor/autoload.php';

function convertToNull($value)
{
	return $value === '' ? null : $value;
}

try {
	// Si el formulario ha sido enviado
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Obtener los valores del formulario
		$job_id     = $_POST['job_id'];
		$job_title      = $_POST['job_title'];
		$min_salary      = $_POST['min_salary'];
		$max_salary      = $_POST['max_salary'];


		// Crear instancia de Jobs
		$job = new Job(
			$job_id,
			$job_title,
			convertToNull($min_salary),
			convertToNull($max_salary)

		);

		// Guardar el job en la base de datos
		$job->save();  // INSERT / UPDATE
		echo "<script>alert('Job creado con éxito.'); window.location.href='jobs.php';</script>";
	}
} catch (\Exception $e) {
	echo "Se ha producido el siguiente error:" . "<br>" . $e->getMessage();
}

?>