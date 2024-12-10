<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar la gorra
    $sql = "DELETE FROM gorras WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
} else {
    echo "ID no proporcionado.";
}

$conn->close();
?>
