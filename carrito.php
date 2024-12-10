<?php
session_start();
include 'conexion.php';

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar productos al carrito
if (isset($_POST['agregarCarrito'])) {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el producto ya está en el carrito
    $existe = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $id) {
            $producto['cantidad'] += $cantidad; // Incrementar la cantidad
            $existe = true;
            break;
        }
    }
    if (!$existe) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'cantidad' => $cantidad
        ];
    }
}

// Eliminar productos del carrito
if (isset($_POST['eliminarProducto'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['carrito'] as $key => $producto) {
        if ($producto['id'] == $id) {
            unset($_SESSION['carrito'][$key]); // Eliminar el producto
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
            break;
        }
    }
}

// Obtener detalles de los productos en el carrito
$productosCarrito = [];
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <h1>Carrito de Compras</h1>

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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($productosCarrito as $producto): 
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?php echo $producto['imagen']; ?>" alt="Imagen de la Gorra" style="max-width: 100px; max-height: 100px;"></td>
                        <td><?php echo htmlspecialchars($producto['tipo']); ?></td>
                        <td><?php echo htmlspecialchars($producto['color']); ?></td>
                        <td><?php echo htmlspecialchars($producto['talla']); ?></td>
                        <td><?php echo number_format($producto['precio'], 2, ',', '.'); ?>€</td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($subtotal, 2, ',', '.'); ?>€</td>
                        <td>
                            <form action="carrito.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" name="eliminarProducto" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">Total</th>
                    <th><?php echo number_format($total, 2, ',', '.'); ?>€</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>

    <br>
    <a href="pagar.php" class="btn">Seguir comprando</a>
    <a href="verGorrasCliente.php" class="btn">Volver atrás</a>

</body>
</html>
