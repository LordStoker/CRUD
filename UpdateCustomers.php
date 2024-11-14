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
        <h1>Customers</h1>
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
                $query = "SELECT * FROM customers WHERE customer_id = ?";
                $stmt = $db->conn->prepare($query);
                $stmt->bind_param("i", $param_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $customer = $result->fetch_assoc();

                    $cust_first_name = $customer['CUST_FIRST_NAME'];
                    // echo $cust_first_name;
                    $cust_last_name = $customer['CUST_LAST_NAME'];
                    // echo $cust_last_name;
                    $date_of_birth = $customer['DATE_OF_BIRTH'];
                    // echo $date_of_birth;
                    $account_mgr_id = $customer['ACCOUNT_MGR_ID'];
                    // echo $account_mgr_id;
                } else {
                    echo "Error: No se encontró el cliente con el ID especificado 2.";
                    exit();
                }
            } else {
                echo "Error: No se ha proporcionado un ID de cliente válido 1.";
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
            <h2>Modificar Customer</h2>
            <form action="EjecutarUpdateCustomers.php" method="POST">
                <label for="customer_id">ID Customer:</label>
                <input type="number" name="customer_id" id="customer_id" value="<?php echo htmlspecialchars($param_id); ?>" readonly required><br><br>

                <label for="cust_first_name">Nombre:</label>
                <input type="text" name="cust_first_name" id="cust_first_name" value="<?php echo htmlspecialchars($cust_first_name); ?>" readonly required><br><br>

                <label for="cust_last_name">Apellidos:</label>
                <input type="text" name="cust_last_name" id="cust_last_name" value="<?php echo htmlspecialchars($cust_last_name); ?>" readonly required><br><br>

                <label for="cust_street_address">Dirección:</label>
                <input type="text" name="cust_street_address" id="cust_street_address" maxlength="100" required><br><br>

                <label for="cust_postal_code">Código postal:</label>
                <input type="text" name="cust_postal_code" id="cust_postal_code" maxlength="10"><br><br>

                <label for="cust_city">Ciudad:</label>
                <input type="text" name="cust_city" id="cust_city" maxlength="20"><br><br>

                <label for="cust_state">Estado:</label>
                <input type="text" name="cust_state" id="cust_state" maxlength="20"><br><br>

                <label for="country">País:</label>
                <input type="text" name="country" id="country" step="0.01" maxlength="20"><br><br>

                <label for="cust_email">Email:</label>
                <input type="email" name="cust_email" id="cust_email" maxlength="30"><br><br>

                <label for="date_of_birth">Fecha de nacimiento:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="2000-01-01" value="<?php echo htmlspecialchars($date_of_birth); ?> " readonly><br><br>

                <label for="account_mgr_id">Account Manager ID:</label>
                <input type="number" name="account_mgr_id" id="account_mgr_id" value="<?php echo htmlspecialchars($account_mgr_id); ?>" readonly><br><br>

                <label for="credit_limit">Credit Limit:</label>
                <input type="number" name="credit_limit" id="credit_limit" required oninput="if(this.value.length > 9) this.value = this.value.slice(0, 9)"><br><br>

                <label for="marital_status">Estado civil:</label>
                <select name="marital_status" id="marital_status">
                    <option value="single">Soltero</option>
                    <option value="married">Casado</option>
                </select><br><br>

                <label for="gender">Género:</label>
                <select name="gender" id="gender">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select><br><br>

                <input type="submit" value="Modificar Customer">
            </form>
        </div>
    </div>




    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>