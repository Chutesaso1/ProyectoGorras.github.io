<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos="escuela";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos",$usuario,$contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conexion->prepare("SELECT id_alumno, Nombre, Apellidos, Edad, Correo_electronico, Materia FROM alumnos");
    $stmt->execute();

    echo "Alumnos existentes en la Base de Datos";
    echo "<table border='1'>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Edad</th>
      <th>Correo Electrónico</th>
      <th>Materia</th>
    </tr>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
        <td>" . $fila["id_alumno"] . "</td>
        <td>" . $fila["Nombre"] . "</td>
        <td>" . $fila["Apellidos"] . "</td>
        <td>" . $fila["Edad"] . "</td>
        <td>" . $fila["Correo_electronico"] . "</td>
        <td>" . $fila["Materia"] . "</td>
      </tr>";

    }

    echo"</table>";
} catch (PDOException $e){
    echo "Error: ".$e->getMessage();
}
$conexion = null;
?>