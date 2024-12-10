<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM gorras WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $color = $_POST['color'];
    $talla = $_POST['talla'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE gorras SET tipo = '$tipo', color = '$color', talla = '$talla', precio = $precio, cantidad = $cantidad WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Producto actualizado con éxito.</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Gorra</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
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
        .success {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Actualizar Gorra</h1>

        <form action="actualizar_gorra.php?id=<?php echo $row['id']; ?>" method="POST">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($row['tipo']); ?>" required>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($row['color']); ?>" required>

            <label for="talla">Talla:</label>
            <select id="talla" name="talla" required>
                <option value="S" <?php echo ($row['talla'] == 'S') ? 'selected' : ''; ?>>S</option>
                <option value="M" <?php echo ($row['talla'] == 'M') ? 'selected' : ''; ?>>M</option>
                <option value="L" <?php echo ($row['talla'] == 'L') ? 'selected' : ''; ?>>L</option>
                <option value="XL" <?php echo ($row['talla'] == 'XL') ? 'selected' : ''; ?>>XL</option>
            </select>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo $row['precio']; ?>" step="0.01" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $row['cantidad']; ?>" required>

            <button type="submit">Actualizar</button>
            <a href="VerInventario.php" class="btn">Volver atras</a>


        </form>
        
    </div>
    
</body>
</html>
