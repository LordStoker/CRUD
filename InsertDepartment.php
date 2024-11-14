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
            <?php
            require 'vendor/autoload.php';

            use Faker\Factory;
            use models\Location;

            $locations = Location::all();

            $faker = Factory::create();


            // var_dump($deparments);

            ?>
            <h2>Datos para añadir nuevo Departamento</h2>
            <form action="Insertdepartment.php" method="POST">
                <label for="department_id">ID Departamento:</label>
                <input type="number" name="department_id" id="department_id" required oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10)"><br><br>

                <label for="department_name">Nombre Departamento:</label>
                <input type="text" name="department_name" id="department_name"  maxlength="30"><br><br>

                <label for="manager_id">ID Manager:</label>
                <select name="manager_id" id="manager_id">
                    <option value="100">Steven King</option>
                    <option value="101">Neena Kochhar</option>
                    <option value="102">Lex De Haan</option>
                    <option value="103">Alexander Hunold</option>
                    <option value="108">Nancy Greenberg</option>
                    <option value="114">Den Raphaely</option>
                    <option value="120">Matthew Weiss</option>
                    <option value="121">Adam Fripp</option>
                    <option value="122">Payam Kaufling</option>
                    <option value="123">Shanta Vollman</option>
                    <option value="124">Kevin Mourgos</option>
                    <option value="145">John Russell</option>
                    <option value="146">Karen Partners</option>
                    <option value="147">Alberto Errazuriz</option>
                    <option value="148">Gerald Cambrault</option>
                    <option value="149">Eleni Zlotkey</option>
                    <option value="201">Michael Hartstein</option>
                    <option value="205">Shelley Higgins</option>
                </select><br><br>

                <label for="location_id">Location ID:</label>
                <select name="location_id" id="location_id" >
                    <?php foreach ($locations as $location) : ?>
                        <option value="<?php echo htmlspecialchars($location->location_id); ?>"><?php echo htmlspecialchars($location->city); ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="submit" value="Añadir Departamento">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>

<?php

use models\Department;


function convertToNull($value)
{
    return $value === '' ? null : $value;
}

try {
    // Si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $department_id     = $_POST['department_id'];
        $department_name      = $_POST['department_name'];
        $manager_id      = $_POST['manager_id'];
        $location_id   = $_POST['location_id'];

        // Crear instancia de departamento
        $department = new Department(
            $department_id,
            $department_name,
            $manager_id,
            $location_id
        );

        // Guardar el departamento en la base de datos
        $department->save();  // INSERT / UPDATE
        echo "<script>alert('Departamento creado con éxito.'); window.location.href='departments.php';</script>";
    }
} catch (\Exception $e) {
    echo "Se ha producido el siguiente error:" . "<br>" . $e->getMessage();
}

?>