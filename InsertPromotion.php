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
    <title>Promotions</title>
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
                        <li><a href="promotions.php">Promotions</a></li>
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
            <h2>Datos para añadir nueva Promoción</h2>
            <form action="InsertPromotion.php" method="POST">
                <label for="promotion_id">Promotion ID:</label>
                <input type="number" name="promotion_id" id="promotion_id" required oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"><br><br>

                <label for="promo_name">Promotion Name:</label>
                <input type="text" name="promo_name" id="promo_name"  maxlength="20">
                <br><br>

                <input type="submit" value="Añadir Promoción">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>

<?php

use models\Promotion;

require_once 'vendor/autoload.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $promotion_id = $_POST['promotion_id'];
        $promo_name = $_POST['promo_name'];

        $promotion = new Promotion(
            $promotion_id,
            $promo_name
        );

        $promotion->save();
        echo "<script>alert('Promoción creada con éxito.'); window.location.href='promotions.php';</script>";
    }
} catch (\Exception $e) {
    echo "Se ha producido el siguiente error:" . "<br>" . $e->getMessage();
}

?>
