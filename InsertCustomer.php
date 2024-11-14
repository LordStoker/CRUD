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
        require 'vendor/autoload.php';

        use Faker\Factory;

        $faker = Factory::create();
        ?>
        <div id="section">
            <h2>Datos para añadir nuevo Customer</h2>
            <form action="InsertCustomer.php" method="POST">
                <label for="customer_id">ID Customer:</label>
                <input type="number" name="customer_id" id="customer_id" required oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"><br><br>

                <label for="cust_first_name">Nombre:</label>
                <input type="text" name="cust_first_name" id="cust_first_name" required maxlength="20"
                    placeholder="<?php
                                    echo $faker->name ?>"><br><br>

                <label for="cust_last_name">Apellidos:</label>
                <input type="text" name="cust_last_name" id="cust_last_name" required maxlength="20"
                    placeholder="<?php
                                    echo $faker->lastname ?>"><br><br>

                <label for="cust_street_address">Dirección:</label>
                <input type="text" name="cust_street_address" id="cust_street_address" required maxlength="100"
                    placeholder="<?php
                                    echo $faker->address ?>"><br><br>

                <label for="cust_postal_code">Números de Teléfono:</label>
                <input type="text" name="cust_postal_code" id="cust_postal_code" maxlength="100"
                    placeholder="<?php
                                    echo $faker->phoneNumber ?>"><br><br>

                <label for="cust_city">Ciudad:</label>
                <input type="text" name="cust_city" id="cust_city" maxlength="20"
                    placeholder="<?php
                                    echo $faker->city ?>"><br><br>

                <label for="cust_state">Estado:</label>
                <input type="text" name="cust_state" id="cust_state" maxlength="20"><br><br>

                <label for="country">País:</label>
                <input type="text" name="country" id="country" step="0.01" maxlength="20"><br><br>

                <label for="cust_email">Email:</label>
                <input type="text" name="cust_email" id="cust_email" maxlength="30"
                    placeholder="<?php
                                    echo $faker->email ?>"><br><br>

                <label for="date_of_birth">Fecha de nacimiento:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="2000-01-01"><br><br>

                <label for="account_mgr_id">Account Manager ID:</label>
                <select name="account_mgr_id" id="account_mgr_id" required>
                    <option value="100">100</option>
                    <option value="101">101</option>
                    <option value="102">102</option>
                    <option value="103">103</option>
                    <option value="108">108</option>
                    <option value="114">114</option>
                    <option value="120">120</option>
                    <option value="121">121</option>
                    <option value="122">122</option>
                    <option value="123">123</option>
                    <option value="124">124</option>
                    <option value="145">145</option>
                    <option value="146">146</option>
                    <option value="147">147</option>
                    <option value="148">148</option>
                    <option value="149">149</option>
                    <option value="201">201</option>
                </select><br><br>

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

                <input type="submit" value="Añadir Customer">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>

<?php

use models\Customer;


// function convertToNull($value) {
//     return $value === '' ? null : $value;
// }
try {
    // Si el formulari ha estat enviat
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtenir els valors del formulari
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

        // Guardar el cliente a la base de datos
        $customer->save();  // INSERT / UPDATE
        echo "<script>alert('Customer creado con éxito.'); window.location.href='customers.php';</script>";
    }
} catch (\Exception $e) {
    echo "S'ha produït el següent error:" . "<br>" . $e->getMessage();
}



?>