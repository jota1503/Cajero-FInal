<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos tiene un nombre diferente
$username = "root"; // Cambia esto por tu nombre de usuario de la base de datos
$password = ""; // Cambia esto por tu contraseña de la base de datos
$dbname = "cajero"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar los datos en la base de datos
if(isset($_POST['cajero']) && isset($_POST['cliente']) && isset($_POST['valor']) && isset($_POST['fecha'])) {
    $cajero = $_POST['cajero'];
    $cliente = $_POST['cliente'];
    $valor = $_POST['valor'];
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO registro_ventas (cajero, cliente, valor, fecha)
            VALUES ('$cajero', '$cliente', '$valor', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro insertado correctamente";
    } else {
        echo "Error al insertar registro: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
          crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .bg-dark {
            background-color: #343a40;
            color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn2 {
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-style: italic;
        }
    </style>
    <title>Usuarios</title>
</head>
<body>
    <div class="container">
        <h2>BUSCADOR DE FECHAS </h2>
        <form action="" method="POST">
            <div class="form-group">
                <label><b>Tipo de Cajero</b></label>
                <select name="cajero_tipo" class="form-control">
                    <option value="">Todos</option>
                    <option value="Cajero 1">Cajero 1</option>
                    <option value="Cajero 2">Cajero 2</option>
                    <option value="Cajero 3">Cajero 3</option>

                    <!-- Agrega más opciones según necesites -->
                </select>
            </div>
            <div class="form-group">
                <label><b>Del Día</b></label>
                <input type="date" name="from_date" class="form-control">
            </div>
            <div class="form-group">
                <label><b>Hasta el Día</b></label>
                <input type="date" name="to_date" class="form-control">
            </div>
            <button type="submit" class="btn">Buscar</button>
            <a href="cajero.html" class="btn2" > ◀ </a>
        </form>
        <?php
            if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
                echo "<table>";
                echo "<thead>";
                echo "<tr class='bg-dark'>";
                echo "<th>Cajero</th>";
                echo "<th>Cliente</th>";
                echo "<th>Valor</th>";
                echo "<th>Fecha</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                $cajero_tipo = isset($_POST['cajero_tipo']) ? $_POST['cajero_tipo'] : '';

                // Construir la consulta SQL con el filtro del tipo de cajero
                $query = "SELECT cajero, cliente, valor, fecha FROM registro_ventas WHERE fecha BETWEEN '$from_date' AND '$to_date' ";
                if (!empty($cajero_tipo)) {
                    $query .= "AND cajero = '$cajero_tipo' ";
                }
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0) {
                    while($row = mysqli_fetch_assoc($query_run)) {
                        echo "<tr>";
                        echo "<td>".$row['cajero']."</td>";
                        echo "<td>".$row['cliente']."</td>";
                        echo "<td>".$row['valor']."</td>";
                        echo "<td>".$row['fecha']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='4'>No se encontraron resultados</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            }
        ?>
    </div>
</body>
</html>
