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
        <h1>Employees</h1>
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
        use models\Job;
        use models\Department;

        // echo $_GET["id"];
        $param_id = null;
        $jobs = Job::all();
        $departments = Department::all();
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
                $query = "SELECT * FROM employees WHERE employee_id = ?";
                $stmt = $db->conn->prepare($query);
                $stmt->bind_param("i", $param_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $employee = $result->fetch_assoc();

                    $first_name = $employee['FIRST_NAME'];

                    $last_name = $employee['LAST_NAME'];

                    $hire_date = $employee['HIRE_DATE'];

                    $manager_id = $employee['MANAGER_ID'];
                    // echo $manager_id;

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
            <h2>Modificar Empleado</h2>
            <form action="EjecutarUpdateEmployees.php" method="POST">
                <label for="employee_id">ID employee:</label>
                <input type="number" name="employee_id" id="employee_id" value="<?php echo htmlspecialchars($param_id); ?>" readonly required><br><br>

                <label for="first_name">Nombre:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($first_name); ?>" readonly required><br><br>

                <label for="last_name">Apellidos:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($last_name); ?>" readonly required><br><br>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" maxlength="25"><br><br>

                <label for="phone_number">Número de Teléfono:</label>
                <input type="text" name="phone_number" id="phone_number" maxlength="20"><br><br>

                <label for="manager_id">Manager ID:</label>
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

                <label for="hire_date">Fecha de Contratación:</label>
                <input type="date" name="hire_date" id="hire_date" value="<?php echo htmlspecialchars($hire_date); ?>" ><br><br>

                <label for="job_id">Job ID:</label>
                <select name="job_id" id="job_id" required>
                <?php foreach ($jobs as $job) : ?>
						<option value="<?php echo htmlspecialchars($job->job_id); ?>"><?php echo htmlspecialchars($job->job_title); ?></option>
					<?php endforeach; ?>


                    <!-- <option value="AD_PRES">Presidente</option>
                    <option value="AD_VP">Vicepresidente</option>
                    <option value="AD_ASST">Asistente</option>
                    <option value="FI_MGR">Director Financiero</option>
                    <option value="FI_ACCOUNT">Contable de Finanzas</option>
                    <option value="AC_MGR">Director de Contabilidad</option>
                    <option value="AC_ACCOUNT">Contable</option>
                    <option value="IT_PROG">Programador</option>
                    <option value="PU_MAN">Director de Compras</option>
                    <option value="PU_CLERK">Empleado de Compras</option>
                    <option value="ST_MAN">Director de Almacén</option>
                    <option value="ST_CLERK">Empleado de Almacén</option>
                    <option value="SH_CLERK">Empleado de Envíos</option>
                    <option value="SA_REP">Representante de Ventas</option>
                    <option value="SA_MAN">Director de Ventas</option>
                    <option value="HR_REP">Representante de RRHH</option>
                    <option value="PR_REP">Representante de RRPP</option>
                    <option value="MK_MAN">Director de Marketing</option>
                    <option value="MK_REP">Representante de Marketing</option> -->
                </select><br><br>

                <label for="salary">Salary:</label>
                <input type="number" name="salary" id="salary"><br><br>

                <label for="commission_pct">Commission PCT:</label>
                <input type="number" name="commission_pct" id="commission_pct"><br><br>

                <label for="department_id">Department ID:</label>
                <select name="department_id" id="department_id">
                <?php foreach ($departments as $department) : ?>
						<option value="<?php echo htmlspecialchars($department->department_id); ?>"><?php echo htmlspecialchars($department->department_name); ?></option>
					<?php endforeach; ?>


                    <!-- <option value="10">Administración</option>
                    <option value="20">Contabilidad</option>
                    <option value="30">RRHH</option>
                    <option value="40">Ventas</option>
                    <option value="50">Marketing</option>
                    <option value="60">IT</option>
                    <option value="70">Logística</option>
                    <option value="80">Compras</option>
                    <option value="90">Producción</option>
                    <option value="100">Calidad</option>
                    <option value="110">Mantenimiento</option> -->
                </select><br><br>
                <input type="submit" value="Modificar Empleado">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>

</html>