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
		<h1>HR & OE Management</h1>
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
			<h3> <--- Selecciona sobre qué tabla trabajar</h3>
		</div>
	</div>

	<div id="footer">
		<p>(c) IES Emili Darder - 2022</p>
	</div>
</body>

</html>