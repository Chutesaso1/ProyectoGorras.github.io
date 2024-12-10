<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Gorra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin: 15px 0 5px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background: #0056b3;
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
    </style>
</head>
<body>
    <h1>Añadir una Gorra</h1>
    <form action="procesar_gorra.php" method="POST" enctype="multipart/form-data">
        <label for="tipo">Tipo de Gorra:</label>
        <input type="text" id="tipo" name="tipo" required>

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" required>

        <label for="talla">Talla:</label>
        <select id="talla" name="talla" required>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="imagen">Imagen de la Gorra:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Guardar Gorra</button>
        </div>
        <center>
        <a href="index.php" class="btn">Volver a la Página Principal</a></center>
    </div>
    </form>
</body>
</html>
