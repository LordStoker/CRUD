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
		<h1>Locations</h1>
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
			<h3>Locations</h3>
			<?php

			use models\Location;

			require_once 'vendor/autoload.php';
			$locations = Location::all();
			echo '<div class="table-responsive">';
			echo '<table class="table table-bordered table-striped">';
			echo
			"<thead>" .
				"<tr>" .
				"<th>#</th>"          .
				"<th>Street Address</th>"  .
                "<th>Postal Code</th>"  .
                "<th>City</th>"  .
                "<th>State Province</th>"  .
                "<th>Country ID</th>"  .
				"<th>Actions " . '<a href="InsertLocation.php' . '" class="mr-2" title="New File " data-toggle="tooltip"><span class="fa fa-pencil-square-o"></span></a>' .
				"</th>" .
				"</tr>" .
				"</thead>";
			echo "<tbody>";
			foreach ($locations as $location) {
				echo
				"<tr>" .
					"<td>" . $location->location_id . "</td>" .
					"<td>" . $location->street_address . "</td>" .
                    "<td>" . $location->postal_code . "</td>" .
                    "<td>" . $location->city . "</td>" .
                    "<td>" . $location->state_province . "</td>" .
                    "<td>" . $location->country_id . "</td>" .
					"<td>" .
					'<a href="UpdateLocations.php?id=' . $location->location_id . '" class="mr-2" title="Update" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>' .
					'<a href="DeleteLocations.php?id=' . $location->location_id . '" class="mr-2" title="Delete" data-toggle="tooltip" onclick="return confirm(\'¿Seguro que quieres eliminar esta localización?\');"><span class="fa fa-trash"></span></a>';
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