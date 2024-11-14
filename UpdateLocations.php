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
        <?php

        require_once 'vendor/autoload.php';

        use config\Database;
        use Faker\Factory;
        $faker = Factory::create();
        // echo $_GET["id"];
        $param_id = null;
        try {
            if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $param_id = trim($_GET["id"]);


                $config = Database::loadConfig("./conf.db");
                $db = new Database(
                    $config["DB_HOST"],
                    $config["DB_PORT"],
                    $config["DB_DATABASE"],
                    $config["DB_USERNAME"],
                    $config["DB_PASSWORD"]
                );

                $db->dbConnect();
                $query = "SELECT * FROM locations WHERE location_id = ?";
                $stmt = $db->conn->prepare($query);
                $stmt->bind_param("i", $param_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $location = $result->fetch_assoc();
                    $country_id = $location['COUNTRY_ID'];
                } else {
                    echo "Error: No se encontró el cliente con el ID especificado.";
                    exit();
                }
            } else {
                echo "Error: No se ha proporcionado un ID de cliente válido.";
                exit();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit();
        } finally {

            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($db->conn)) {
                $db->dbClose();
            }
        }

        ?>
        <div id="section">
            <h2>Modificar Location</h2>
            <form action="EjecutarUpdateLocations.php" method="POST">
            <label for="location_id">Location ID:</label>
				<input type="number" name="location_id" id="location_id" required value="<?php echo htmlspecialchars($param_id); ?>"readonly><br><br>

				<label for="street_address">Street Address:</label>
				<input type="text" name="street_address" id="street_address" maxlength="40"
					placeholder="<?php
									echo $faker->address ?>"><br><br>
                            
                <label for="postal_code">Postal Code:</label>
                <input type="text" name="postal_code" id="postal_code" maxlength="12" ><br><br>

                <label for="city">City:</label>
				<input type="text" name="city" id="city" maxlength="30"><br><br>

                <label for="state_province">State Province:</label>
				<input type="text" name="state_province" id="state_province" maxlength="25" ><br><br>

                <label for="country_id">Country ID:</label>
				<input type="text" name="country_id" id="country_id" value="<?php echo htmlspecialchars($country_id); ?>"><br><br>


                <input type="submit" value="Modificar Location">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>