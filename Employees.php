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
	<link rel="stylesheet" href="styles.css">
	<title>Human Resource</title>
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
			<h3>Employees</h3>
			<?php

			use models\Employee;

			require_once 'vendor/autoload.php';
			$employees = Employee::all();
			echo '<table class="table table-bordered table-striped">';
			echo
			"<thead>" .
				"<tr>" .
				"<th>#</th>"          .
				"<th>Last Name</th>"  .
				"<th>First Name</th>" .
				"<th>Department_ID</th>" .
				"<th>Actions " . '<a href="InsertEmployee.php' . '" class="mr-2" title="New Employee" data-toggle="tooltip"><span class="fa fa-pencil-square-o"></span></a>' .
				"</th>" .
				"</tr>" .
				"</thead>";
			echo "<tbody>";
			foreach ($employees as $employee) {
				echo
				"<tr>" .
					"<td>" . $employee->employee_id     . "</td>" .
					"<td>" . $employee->last_name       . "</td>" .
					"<td>" . $employee->first_name      . "</td>" .
					"<td>" . $employee->department_id . "</td>" .
					"<td>" . '<a href="VerDetallesEmployee.php?id=' . $employee->employee_id . '" class="mr-2" title="View Employee" data-toggle="tooltip"><span class="fa fa-eye"></span></a>'      .
					'<a href="UpdateEmployees.php?id=' . $employee->employee_id . '" class="mr-2" title="Update Employee" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>' .
					'<a href="DeleteEmployee.php?id=' . $employee->employee_id . '" class="mr-2" title="Delete Employee" data-toggle="tooltip" onclick="return confirm(\'¿Seguro que quieres eliminar este empleado?\');"><span class="fa fa-trash"></span></a>';
				"</td>" .
					"</tr>";
			}
			echo "</tbody>";
			echo "</table>";

			?>
		</div>
	</div>

	<div id="footer">
		<p>(c) IES Emili Darder - 2022</p>
	</div>
</body>

</html>