<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required />
        <button type="submit">Upload</button>
    </form>

    <?php
    // Define el directorio de imágenes
    $directory = __DIR__ . "/images/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        // Referencia al archivo subido
        $image_file = $_FILES["image"];

        // Verifica si hubo algun error al subir
        if ($image_file['error'] !== UPLOAD_ERR_OK) {
            die("Error al subir la imagen. Código de error: " . $image_file['error']);
        }

        // Mueve el archivo subido al directorio de destino
        $destination = $directory . basename($image_file["name"]);
        if (move_uploaded_file($image_file["tmp_name"], $destination)) {
            echo "<p>Imagen cargada con éxito: " . htmlspecialchars($image_file["name"]) . "</p>";
        } else {
            echo "<p>Error al mover el archivo al directorio de destino.</p>";
        }
    }

    // Mostrar todas las imagenes en el directorio
    $images = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

    if (!empty($images)) {
        echo "<h2>Imágenes subidas:</h2>";
        echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
        foreach ($images as $image) {
            $imageUrl = str_replace(__DIR__, '', $image); // Convertir ruta absoluta a relativa
            echo "<div>
                    <img src='$imageUrl' alt='Imagen' style='max-width: 150px; max-height: 150px;'>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay imágenes en el directorio.</p>";
    }
    ?>
</body>
</html>
