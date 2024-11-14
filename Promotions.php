<?php
session_start();
ob_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Para acceder a esta área necesitas loguearte primero. Clica en Aceptar para ir al login'); window.location.href='iniciosesion.php';</script>";
    exit();
}

ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Promotions</title>
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
        <h1>Promotions</h1>
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
						<li><a href="Promotion.php">Promotions</a></li>
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
            <h3>Promotions</h3>
            <?php
            use models\Promotion;

            require_once 'vendor/autoload.php';
            $promotions = Promotion::all();
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped">';
            echo
            "<thead>" .
                "<tr>" .
                "<th>#</th>" .
                "<th>Promotion Name</th>" .
                "<th>Actions " . '<a href="InsertPromotion.php' . '" class="mr-2" title="New Promotion" data-toggle="tooltip"><span class="fa fa-pencil-square-o"></span></a>' .
                "</th>" .
                "</tr>" .
                "</thead>";
            echo "<tbody>";
            foreach ($promotions as $promotion) {
                echo
                "<tr>" .
                    "<td>" . $promotion->promotion_id . "</td>" .
                    "<td>" . $promotion->promo_name . "</td>" .
                    "<td>" .
                    '<a href="UpdatePromotions.php?id=' . $promotion->promotion_id . '" class="mr-2" title="Update" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>' .
                    '<a href="DeletePromotions.php?id=' . $promotion->promotion_id . '" class="mr-2" title="Delete" data-toggle="tooltip" onclick="return confirm(\'¿Seguro que quieres eliminar esta promoción?\');"><span class="fa fa-trash"></span></a>';
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
