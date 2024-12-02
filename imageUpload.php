<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload images</title>
</head>
<body>
    <h1>Subir imagen</h1>
    <form action="imageUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required/>
        <button type="submit">Upload</button>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $uploadDir = '/var/www/html/images/'; //directorio
        
        //archivo enviado:
        if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK){
            $fileName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            // Verifica el tipo de archivo
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            if (strpos($fileType, 'image') === false) {
                echo "El archivo no es una imagen válida.";
                exit;
            }

            // Mueve el archivo al directorio de destino
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "Imagen subida con éxito: " . htmlspecialchars($fileName) . "<br>";
            } else {
                echo "Error al mover el archivo.<br>";
            }
        }else {
            echo "No se recibió ningún archivo o hubo un error en la subida.<br>";
        }
    }

        // Mostrar todas las imágenes en el directorio
    $uploadDirectory = '/var/www/html/images/';
    $images = glob($uploadDirectory . "*.{jpg,jpeg,png,gif,bmp,webp}", GLOB_BRACE);
    $totalImages = count($images);

    echo "<h2>Número total de imágenes en el directorio: $totalImages</h2>";

    
    ?>
</body>
</html>