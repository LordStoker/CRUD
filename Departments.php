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
			width: 100%;
			margin: 0 auto;
		}

		table {
			width: 100%;
			table-layout: auto;
		}

		table th,
		table td {
			white-space: wrap;
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
		<h1>Departments</h1>
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
			<h3>Departments</h3>
			<?php

			use models\Department;
			require_once 'vendor/autoload.php';
			$departments = Department::all();
			echo '<div class="table-responsive">';
			echo '<table class="table table-bordered table-striped">';
			echo
			"<thead>" .
				"<tr>" .
				"<th>#</th>"          .
				"<th>Nombre Departamento</th>"  .
				"<th>Manager ID</th>" .
				"<th>Location ID</th>" .
				"<th>Actions " . '<a href="InsertDepartment.php' . '" class="mr-2" title="New Department" data-toggle="tooltip"><span class="fa fa-pencil-square-o"></span></a>' .
				"</th>" .
				"</tr>" .
				"</thead>";
			echo "<tbody>";
			foreach ($departments as $department) {
				echo
				"<tr>" .
					"<td>" . $department->department_id . "</td>" .
					"<td>" . $department->department_name . "</td>" .
					"<td>" . $department->manager_id . "</td>" .
					"<td>" . $department->location_id . "</td>" .
					"<td>" .
					'<a href="Updatedepartments.php?id=' . $department->department_id . '" class="mr-2" title="Update Department" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>' .
					'<a href="Deletedepartments.php?id=' . $department->department_id . '" class="mr-2" title="Delete Department" data-toggle="tooltip" onclick="return confirm(\'¿Seguro que quieres eliminar este departamento?\');"><span class="fa fa-trash"></span></a>';
				"</td>";
				"</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			?>
		</div>
	</div>

	<div id="footer">
		<p>(c) IES Emili Darder - 2022</p>
	</div>
</body>

</html>