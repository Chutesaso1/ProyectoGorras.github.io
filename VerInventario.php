<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

$sql = "SELECT * FROM gorras"; // Consulta para obtener todas las gorras
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Gorras</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .imagen-gorra {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            margin: 0 auto;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Inventario de Gorras</h1>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Tipo</th>
                <th>Color</th>
                <th>Talla</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $row['imagen']; ?>" alt="Imagen de la Gorra" class="imagen-gorra"></td>
                    <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($row['color']); ?></td>
                    <td><?php echo htmlspecialchars($row['talla']); ?></td>
                    <td><?php echo number_format($row['precio'], 2, ',', '.'); ?>€</td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td>
                        <a href="actualizar_gorra.php?id=<?php echo $row['id']; ?>" class="btn">Actualizar</a>
                        <a href="eliminar_gorra.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta gorra?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay gorras en el inventario.</p>
    <?php endif; ?>

</div>
</div>
<center>
<a href="indexAdmin.php" class="btn">Volver a la Página Principal</a></center>
</div>
</body>
</html>

<?php
$conn->close(); // Cierra la conexión a la base de datos
?>
