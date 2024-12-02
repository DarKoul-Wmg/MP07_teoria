<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Video</title>
</head>
<body>
    <h1>Subir un Video</h1>
    <form action="videoUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="video" accept="video/*" required />
        <button type="submit">Subir Video</button>
    </form>
    <?php
// Ruta donde se almacenarán los videos
$uploadDir = __DIR__ . "/videos/";

// Crear el directorio si no existe
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Manejar la subida del archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $videoFile = $_FILES['video'];

    // Verificar errores en el archivo
    if ($videoFile['error'] !== UPLOAD_ERR_OK) {
        die("Error al subir el video. Código de error: " . $videoFile['error']);
    }

    // Validar el tamaño del archivo (máximo 100 MB en este caso)
    if ($videoFile['size'] > 100 * 1024 * 1024) {
        die("El archivo es demasiado grande. Máximo permitido: 100 MB.");
    }

    // Validar el tipo MIME del archivo (solo videos)
    $mimeType = mime_content_type($videoFile['tmp_name']);
    if (strpos($mimeType, 'video/') !== 0) {
        die("El archivo subido no es un video válido.");
    }

    // Ruta destino para guardar el video
    $destination = $uploadDir . basename($videoFile['name']);

    // Mover el archivo subido al directorio
    if (move_uploaded_file($videoFile['tmp_name'], $destination)) {
        echo "<p>Video subido con éxito: " . htmlspecialchars($videoFile['name']) . "</p>";
    } else {
        echo "<p>Error al guardar el archivo en el servidor.</p>";
    }
}

// Mostrar los videos disponibles en el directorio
$videos = glob($uploadDir . "*.{mp4,avi,mkv,webm,flv,mov}", GLOB_BRACE);
if (!empty($videos)) {
    echo "<h2>Videos disponibles:</h2>";
    echo "<div>";
    foreach ($videos as $video) {
        $videoUrl = "videos/" . basename($video); // Ruta web relativa
        echo "<div style='margin-bottom: 20px;'>
                <video controls width='320' height='240'>
                    <source src='$videoUrl' type='video/mp4'>
                    Tu navegador no soporta la reproducción de videos.
                </video>
                <p>" . basename($video) . "</p>
              </div>";
    }
    echo "</div>";
} else {
    echo "<p>No hay videos disponibles.</p>";
}
?>
</body>
</html>
