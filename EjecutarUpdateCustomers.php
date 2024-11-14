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
        <h1>Modificar Customer</h1>
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

        use models\Customer;

        require 'vendor/autoload.php';
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $customer_id        = $_POST['customer_id'];
                $cust_first_name    = $_POST['cust_first_name'];
                $cust_last_name     = $_POST['cust_last_name'];
                $cust_street_address = $_POST['cust_street_address'];
                $cust_postal_code   = $_POST['cust_postal_code'];
                $cust_city          = $_POST['cust_city'];
                $cust_state         = $_POST['cust_state'];
                $country            = $_POST['country'];
                $cust_email         = $_POST['cust_email'];
                $date_of_birth      = $_POST['date_of_birth'];
                $account_mgr_id     = $_POST['account_mgr_id'];
                $marital_status     = $_POST['marital_status'];
                $gender             = $_POST['gender'];
                $CREDIT_LIMIT       = $_POST['credit_limit'];
                $PHONE_NUMBERS = null;
                $NLS_LANGUAGE = null;
                $NLS_TERRITORY = null;
                $CUST_GEO_LOCATION = null;
                $INCOME_LEVEL = null;

                $customer = new Customer(
                    $customer_id,
                    $cust_first_name,
                    $cust_last_name,
                    $cust_street_address,
                    $cust_postal_code,
                    $cust_city,
                    $cust_state,
                    $country,
                    $PHONE_NUMBERS,
                    $NLS_LANGUAGE,
                    $NLS_TERRITORY,
                    $CREDIT_LIMIT,
                    $cust_email,
                    $account_mgr_id,
                    $CUST_GEO_LOCATION,
                    $date_of_birth,
                    $marital_status,
                    $gender,
                    $INCOME_LEVEL
                );

                $customer->save();
                echo "<script>alert('Customer modificado con éxito.'); window.location.href='customers.php';</script>";
            }
        } catch (Exception $e) {
            echo "S'ha produït el següent error:" . "<br>" . $e->getMessage();
        }
        ?>