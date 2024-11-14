<?php
session_start();
ob_start(); // necesario para la redirección de 'header()'

// Comprobar si el usuario ha iniciado sesión
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
    <title>Human Resource - Modificar Departamento</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

        <?php
        require_once 'vendor/autoload.php';
        
        use config\Database;
        use models\Department;

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
                $query = "SELECT * FROM departments WHERE department_id = ?";
                $stmt = $db->conn->prepare($query);
                $stmt->bind_param("i", $param_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $department = $result->fetch_assoc();
                    $deparment_name = $department['DEPARTMENT_NAME'];
                    $location_id = $department['LOCATION_ID'];
                } else {
                    echo "Error: No se encontró el departamento con el ID especificado.";
                    exit();
                }
            } else {
                echo "Error: No se ha proporcionado un ID de departamento válido.";
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
            <h2>Modificar Departamento</h2>
            <form action="EjecutarUpdateDepartments.php" method="POST">
                <label for="department_id">ID Department:</label>
                <input type="number" name="department_id" id="department_id" value="<?php echo htmlspecialchars($param_id); ?>" readonly required><br><br>

                <label for="department_name">Nombre del Departamento:</label>
                <input type="text" name="department_name" id="department_name" placeholder="<?php echo htmlspecialchars($deparment_name)?>" ><br><br>

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

                <label for="location_id">Location ID:</label>
                <input type="number" name="location_id" id="location_id" value="<?php echo htmlspecialchars($location_id); ?>"><br><br>

                <input type="submit" value="Modificar Departamento">
            </form>
        </div>
    </div>

    <div id="footer">
        <p>(c) IES Emili Darder - 2022</p>
    </div>
</body>
</html>
