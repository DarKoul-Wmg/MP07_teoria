<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex fita 6 insert</title>
</head>

<body>
<?php
$dsn = "mysql:host=localhost;dbname=classicmodels;charset=utf8mb4";
$username = "admin";
$password = "admin123";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
    <h1>Crear Producte</h1>
    <form method="post">
    <label for="productName">Nom del producte:</label>
    <input type="text" id="productName" name="productName" required>
    <br><br>
    <label for="productLine">Línia de producte:</label>
    <select id="productLine" name="productLine" required>
        <?php
        $query = "SELECT productLine FROM productlines";
        $stmt = $pdo->query($query);
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            echo "<option value='" . $row['productLine'] . "'>" . $row['productLine'] . "</option>";
        }
        ?>
    </select>
    <br><br>
    <label for="productScale">Escala del producte:</label>
    <input type="text" id="productScale" name="productScale" required>
    <br><br>
    <label for="productVendor">Proveïdor del producte:</label>
    <input type="text" id="productVendor" name="productVendor" required>
    <br><br>
    <label for="productDescription">Descripció del producte:</label>
    <textarea id="productDescription" name="productDescription" required></textarea>
    <br><br>
    <label for="quantityInStock">Quantitat en estoc:</label>
    <input type="number" id="quantityInStock" name="quantityInStock" required>
    <br><br>
    <label for="buyPrice">Preu de compra:</label>
    <input type="number" id="buyPrice" step="0.01" name="buyPrice" required>
    <br><br>
    <label for="MSRP">PVP:</label>
    <input type="number" id="MSRP" step="0.01" name="MSRP" required>
    <br><br>
    <input type="submit" value="Afegir">
</form>
    <br>
    <?php
    function generateProductCode() {
        // Selecciona un prefijo aleatorio entre S10 y S99
        $code = 'S' . rand(10, 99);
        $code .= '_';
        // Genera un número aleatorio de 4 dígitos
        $code .= str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        
        return $code;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productCode = generateProductCode();
        $productName = $_POST['productName'];
        $productLine = $_POST['productLine'];
        $productScale = $_POST['productScale'];
        $productVendor = $_POST['productVendor'];
        $productDescription = $_POST['productDescription'];
        $quantityInStock = $_POST['quantityInStock'];
        $buyPrice = $_POST['buyPrice'];
        $MSRP = $_POST['MSRP'];

        $sql = "INSERT INTO products 
                (productCode, productName, productLine, productScale, productVendor, productDescription, quantityInStock, buyPrice, MSRP) 
                VALUES (:productCode, :productName, :productLine, :productScale, :productVendor, :productDescription, :quantityInStock, :buyPrice, :MSRP)";

        try {
            $stmt = $pdo->prepare($sql);
            // Enlazamos las variables usando bindParam()
            $stmt->bindParam(':productCode', $productCode, PDO::PARAM_STR);
            $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
            $stmt->bindParam(':productLine', $productLine, PDO::PARAM_STR);
            $stmt->bindParam(':productScale', $productScale, PDO::PARAM_STR);
            $stmt->bindParam(':productVendor', $productVendor, PDO::PARAM_STR);
            $stmt->bindParam(':productDescription', $productDescription, PDO::PARAM_STR);
            $stmt->bindParam(':quantityInStock', $quantityInStock, PDO::PARAM_INT);
            $stmt->bindParam(':buyPrice', $buyPrice, PDO::PARAM_STR);
            $stmt->bindParam(':MSRP', $MSRP, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $stmt->execute();
            echo "Producte afegit correctament.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
