<?php
include 'conexion.php'; // Conexión a la base de datos

// Registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $registro_exitoso = "Usuario registrado exitosamente.";
    } else {
        $registro_error = "Error al registrar: " . $conn->error;
    }
}

// Inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Verificar el rol del usuario
            if ($user['rol'] === 'admin') {
                header("Location: indexAdmin.php");
            } elseif ($user['rol'] === 'cliente') {
                header("Location: indexCliente.php");
            } else {
                echo "Rol no reconocido.";
            }
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            display: flex;
            flex-direction: row;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background: #ffffff;
        }
        .form-container {
            flex: 1;
            padding: 20px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container form input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container form button {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
        .left {
            border-right: 1px solid #ddd;
        }
        .message {
            text-align: center;
            margin: 15px 0;
            color: #28a745;
        }
        .error {
            text-align: center;
            margin: 15px 0;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Registro -->
        <div class="form-container left">
            <h2>Registro</h2>
            <?php if (isset($registro_exitoso)) echo "<p class='message'>$registro_exitoso</p>"; ?>
            <?php if (isset($registro_error)) echo "<p class='error'>$registro_error</p>"; ?>
            <form action="auth.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="register">Registrarse</button>
            </form>
        </div>

        <!-- Inicio de Sesión -->
        <div class="form-container right">
            <h2>Inicio de Sesión</h2>
            <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
            <form action="auth.php" method="POST">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
