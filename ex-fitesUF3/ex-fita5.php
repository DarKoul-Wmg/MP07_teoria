<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex fita 5 JOIN</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th{
            background-color: grey;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Buscar Clientes</h1>
    <form method="POST">
        <label for="nombre">Buscar por nombre o apellido:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre o Apellido">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    $dsn = "mysql:host=localhost;dbname=classicmodels;charset=utf8mb4";
    $username = "admin";
    $password = "admin123";

    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $search_name = isset($_POST['nombre']) ? $_POST['nombre'] : '';

        $sql = "SELECT c.contactFirstName, c.contactLastName, o.orderNumber, o.orderDate, o.status
                FROM customers c
                JOIN orders o ON c.customerNumber = o.customerNumber";
        
        if (!empty($search_name)) {
            $sql .= " WHERE c.contactFirstName LIKE :name OR c.contactLastName LIKE :name";
        }

        $stmt = $pdo->prepare($sql);
        
        if (!empty($search_name)) {
            $stmt->bindValue(':name', "%$search_name%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $results = $stmt->fetchAll();

        if ($results) {
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Apellido</th><th>Número de Orden</th><th>Fecha de Orden</th><th>Estado</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . ($row["contactFirstName"]) . "</td>";
                echo "<td>" . ($row["contactLastName"]) . "</td>";
                echo "<td>" . ($row["orderNumber"]) . "</td>";
                echo "<td>" . ($row["orderDate"]) . "</td>";
                echo "<td>" . ($row["status"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }

    } catch (PDOException $e) {
        echo "<p>Error de conexión: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
