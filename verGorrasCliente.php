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
                <th>Stock</th>
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
                        <form action="carrito.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <label for="cantidad_<?php echo $row['id']; ?>">Cantidad:</label>
                            <input type="number" id="cantidad_<?php echo $row['id']; ?>" name="cantidad" value="1" min="1" max="<?php echo $row['cantidad']; ?>" required>
                            <button type="submit" name="agregarCarrito" class="btn">Agregar al carrito</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay gorras en el inventario.</p>
    <?php endif; ?>

</div>
<center>
<a href="indexCliente.php" class="btn">Volver a la Página Principal</a></center>

</body>
</html>

<?php
$conn->close(); // Cierra la conexión a la base de datos
?>
