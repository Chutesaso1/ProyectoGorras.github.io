<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $tipo = $_POST['tipo'];
    $color = $_POST['color'];
    $talla = $_POST['talla'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Manejar el archivo de imagen
    $directorio = "uploads/"; // Carpeta para guardar imágenes
    $nombreArchivo = basename($_FILES['imagen']['name']);
    $rutaCompleta = $directorio . $nombreArchivo;

    // Crear la carpeta si no existe
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    // Mover el archivo subido a la carpeta
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO gorras (tipo, color, talla, precio, cantidad, imagen) 
                VALUES ('$tipo', '$color', '$talla', $precio, $cantidad, '$rutaCompleta')";

        if ($conn->query($sql) === TRUE) {
            echo "Gorra añadida con éxito.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error al subir la imagen.";
    }
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>
