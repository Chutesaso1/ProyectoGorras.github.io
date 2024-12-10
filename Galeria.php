<?php
// Ruta de la carpeta que contiene las imágenes
$directorio = "imagenes/";

// Abrir la carpeta y leer los archivos
$archivos = array_diff(scandir($directorio), array('.', '..')); // Filtramos '.' y '..' para que no aparezcan como archivos

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Imágenes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .galeria {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }
        .galeria img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .galeria img:hover {
            transform: scale(1.05);
        }
        .imagen-container {
            overflow: hidden;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
        }
        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

    <h1>Galería de Imágenes</h1>
    
    <div class="galeria">
        <?php
        // Mostrar todas las imágenes
        foreach ($archivos as $archivo) {
            // Verificar si el archivo es una imagen
            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                echo '<div class="imagen-container">';
                echo '<img src="' . $directorio . $archivo . '" alt="' . $archivo . '">';
                echo '</div>';
            }
        }
        ?>
    </div>
    
    </div>

<a href="index.php" class="btn">Volver a la Página Principal</a>
</div>
    <footer>
        <p>&copy; 2024 Galería de Imágenes</p>
    </footer>

</body>
</html>
