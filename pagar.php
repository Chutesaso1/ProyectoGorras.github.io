<?php
session_start();
include 'conexion.php';

// Verificar si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    header("Location: indexCliente.php");
    exit();
}

// Obtener detalles de los productos en el carrito
$productosCarrito = [];
$total = 0;

if (!empty($_SESSION['carrito'])) {
    $ids = array_column($_SESSION['carrito'], 'id');
    $sql = "SELECT * FROM gorras WHERE id IN (" . implode(',', $ids) . ")";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        foreach ($_SESSION['carrito'] as $producto) {
            if ($producto['id'] == $row['id']) {
                $row['cantidad'] = $producto['cantidad'];
                $productosCarrito[] = $row;
                break;
            }
        }
    }

    // Calcular el total
    foreach ($productosCarrito as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pago</title>
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
        .form-group {
            margin-bottom: 15px;
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
    </style>
</head>
<body>
    <h1>Realizar Pago</h1>

    <?php if (!empty($productosCarrito)): ?>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Talla</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($productosCarrito as $producto): 
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                ?>
                    <tr>
                        <td><img src="<?php echo $producto['imagen']; ?>" alt="Imagen de la Gorra" style="max-width: 100px; max-height: 100px;"></td>
                        <td><?php echo htmlspecialchars($producto['tipo']); ?></td>
                        <td><?php echo htmlspecialchars($producto['color']); ?></td>
                        <td><?php echo htmlspecialchars($producto['talla']); ?></td>
                        <td><?php echo number_format($producto['precio'], 2, ',', '.'); ?>€</td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($subtotal, 2, ',', '.'); ?>€</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">Total</th>
                    <th><?php echo number_format($total, 2, ',', '.'); ?>€</th>
                </tr>
            </tfoot>
        </table>

        <br>
        <h2>Ingrese los detalles de su tarjeta para completar la compra:</h2>
        <form action="procesar_pago.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del titular de la tarjeta:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="numeroTarjeta">Número de tarjeta:</label>
                <input type="text" id="numeroTarjeta" name="numeroTarjeta" maxlength="16" required>
            </div>
            <div class="form-group">
                <label for="fechaExpiracion">Fecha de expiración:</label>
                <input type="text" id="fechaExpiracion" name="fechaExpiracion" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" maxlength="3" required>
            </div>
            <a href="indexCliente.php" class="btn">Realizar Pago</a>

        </form>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</body>
<a href="verGorrasCliente.php" class="btn">Volver atrás</a>

</html>
