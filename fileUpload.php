<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1, h2 {
            color: #333;
        }
        .form-container {
            margin-bottom: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        .file-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .file-item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            width: 150px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        video {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <h1>Subir Archivos</h1>

    <div class="form-container">
        <h2>Subir Imagen</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required />
            <button type="submit" name="uploadImage">Subir Imagen</button>
        </form>

        <h2>Subir Video</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="video" accept="video/*" required />
            <button type="submit" name="uploadVideo">Subir Video</button>
        </form>
    </div>

    <?php
    // Directorios de subida
    $imageDir = __DIR__ . "/images/";
    $videoDir = __DIR__ . "/videos/";

    // Crear directorios si no existen
    if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);
    if (!is_dir($videoDir)) mkdir($videoDir, 0755, true);

    // Subida de imagenes
    if (isset($_POST['uploadImage']) && isset($_FILES['image'])) {
        $imageFile = $_FILES['image'];
        if ($imageFile['error'] === UPLOAD_ERR_OK) {
            $imageType = mime_content_type($imageFile['tmp_name']);
            if (strpos($imageType, 'image') === 0) {
                $destination = $imageDir . basename($imageFile['name']);
                if (move_uploaded_file($imageFile['tmp_name'], $destination)) {
                    echo "<p>Imagen subida con éxito: " . htmlspecialchars($imageFile['name']) . "</p>";
                } else {
                    echo "<p>Error al mover la imagen al servidor.</p>";
                }
            } else {
                echo "<p>El archivo seleccionado no es una imagen válida.</p>";
            }
        } else {
            echo "<p>Error al subir la imagen. Código: " . $imageFile['error'] . "</p>";
        }
    }

    // Subida de videos
    if (isset($_POST['uploadVideo']) && isset($_FILES['video'])) {
        $videoFile = $_FILES['video'];
        if ($videoFile['error'] === UPLOAD_ERR_OK) {
            $videoType = mime_content_type($videoFile['tmp_name']);
            if (strpos($videoType, 'video') === 0) {
                $destination = $videoDir . basename($videoFile['name']);
                if (move_uploaded_file($videoFile['tmp_name'], $destination)) {
                    echo "<p>Video subido con éxito: " . htmlspecialchars($videoFile['name']) . "</p>";
                } else {
                    echo "<p>Error al mover el video al servidor.</p>";
                }
            } else {
                echo "<p>El archivo seleccionado no es un video válido.</p>";
            }
        } else {
            echo "<p>Error al subir el video. Código: " . $videoFile['error'] . "</p>";
        }
    }

    // Mostrar imágenes
    echo "<h2>Imágenes Subidas</h2>";
    $images = glob($imageDir . "*.{jpg,jpeg,png,gif,bmp,webp}", GLOB_BRACE);
    if (!empty($images)) {
        echo "<div class='file-list'>";
        foreach ($images as $image) {
            $imageUrl = "images/" . basename($image);
            echo "<div class='file-item'>
                    <img src='$imageUrl' alt='Imagen subida' />
                    <p>" . basename($image) . "</p>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay imágenes disponibles.</p>";
    }

    // Mostrar videos
    echo "<h2>Videos Subidos</h2>";
    $videos = glob($videoDir . "*.{mp4,avi,mkv,webm,flv,mov}", GLOB_BRACE);
    if (!empty($videos)) {
        echo "<div class='file-list'>";
        foreach ($videos as $video) {
            $videoUrl = "videos/" . basename($video);
            echo "<div class='file-item'>
                    <video controls>
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
