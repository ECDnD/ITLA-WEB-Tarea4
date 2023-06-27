<!DOCTYPE html>
<html>
<head>
  <title>CRUD de Personajes de Anime</title>
</head>
<body>
  <?php
  include 'edit.php';
  $id = $_GET['id'] ?? '';
  $nombre = $_GET['nombre'] ?? '';
  $apellido = $_GET['apellido'] ?? '';
  $cedula = $_GET['cedula'] ?? '';
  $nacionalidad = $_GET['nacionalidad'] ?? '';
  $raza = $_GET['raza'] ?? '';
  $ocupacion = $_GET['ocupacion'] ?? '';
  $sexo = $_GET['sexo'] ?? '';
  $fecha_nacimiento = $_GET['fecha_nacimiento'] ?? '';
  $poder = $_GET['poder'] ?? '';
  $latitud = $_GET['latitud'] ?? '';
  $longitud = $_GET['longitud'] ?? '';
  $anime = $_GET['anime'] ?? '';
  $estado = $_GET['estado'] ?? '';
  $biografia = $_GET['biografia'] ?? '';
  $foto = $_GET['foto'] ?? '';

  // Configuración de la base de datos
  $db_host = 'localhost';
  $db_username = 'root';
  $db_password = '';
  $db_name = 'tarea4';

  // Conexión a la base de datos
  $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  // Función para limpiar y validar datos enviados por el formulario
  function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Agregar personaje
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $nombre = clean_input($_POST['nombre']);
    $apellido = clean_input($_POST['apellido']);
    $cedula = clean_input($_POST['cedula']);
    $nacionalidad = clean_input($_POST['nacionalidad']);
    $raza = clean_input($_POST['raza']);
    $ocupacion = clean_input($_POST['ocupacion']);
    $sexo = clean_input($_POST['sexo']);
    $fecha_nacimiento = clean_input($_POST['fecha_nacimiento']);
    $poder = clean_input($_POST['poder']);
    $latitud = clean_input($_POST['latitud']);
    $longitud = clean_input($_POST['longitud']);
    $anime = clean_input($_POST['anime']);
    $estado = clean_input($_POST['estado']);
    $biografia = clean_input($_POST['biografia']);
    $foto = clean_input($_POST['foto']);

    $sql = "INSERT INTO characters (nombre, apellido, cedula, nacionalidad, raza, ocupacion, sexo, fecha_nacimiento, poder, latitud, longitud, anime, estado, biografia, foto) 
    VALUES ('$nombre', '$apellido', '$cedula', '$nacionalidad', '$raza', '$ocupacion', '$sexo', '$fecha_nacimiento', '$poder', '$latitud', '$longitud', '$anime', '$estado', '$biografia', '$foto')";
    if ($conn->query($sql) === TRUE) {
      echo "Personaje agregado exitosamente.";
    } else {
      echo "Error al agregar el personaje: " . $conn->error;
    }
  }

  // Eliminar personaje
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM characters WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "Personaje eliminado exitosamente.";
    } else {
      echo "Error al eliminar el personaje: " . $conn->error;
    }
  }

  // Modificar personaje
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = clean_input($_POST['nombre']);
    $apellido = clean_input($_POST['apellido']);
    $cedula = clean_input($_POST['cedula']);
    $nacionalidad = clean_input($_POST['nacionalidad']);
    $raza = clean_input($_POST['raza']);
    $ocupacion = clean_input($_POST['ocupacion']);
    $sexo = clean_input($_POST['sexo']);
    $fecha_nacimiento = clean_input($_POST['fecha_nacimiento']);
    $poder = clean_input($_POST['poder']);
    $latitud = clean_input($_POST['latitud']);
    $longitud = clean_input($_POST['longitud']);
    $anime = clean_input($_POST['anime']);
    $estado = clean_input($_POST['estado']);
    $biografia = clean_input($_POST['biografia']);
    $foto = clean_input($_POST['foto']);

    $sql = "UPDATE characters SET nombre='$nombre', apellido='$apellido', cedula='$cedula', nacionalidad='$nacionalidad', raza='$raza', ocupacion='$ocupacion', sexo='$sexo', fecha_nacimiento='$fecha_nacimiento', poder='$poder', latitud='$latidud', longitud='$longitud', anime='$anime', estado='$estado', biografia='$biografia', foto='$foto' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
      echo "Personaje modificado exitosamente.";
    } else {
      echo "Error al modificar el personaje: " . $conn->error;
    }
  }

  // Obtener todos los personajes
  $sql = "SELECT * FROM characters";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Mostrar los personajes en una tabla
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Anime</th><th>Descripción</th><th>Acciones</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['nombre'] . "</td>";
      echo "<td>" . $row['anime'] . "</td>";
      echo "<td>" . $row['description'] . "</td>";
      echo "<td><a href='index.php?delete=" . $row['id'] . "'>Eliminar</a> | <a href='edit.php?id=" . $row['id'] . "'>Editar</a></td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No se encontraron personajes.";
  }

  $conn->close();
  ?>

  <h2>Agregar Personaje</h2>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label for="anime">Anime:</label>
    <input type="text" name="anime" required><br>

    <label for="description">Descripción:</label><br>
    <textarea name="description" rows="4" cols="50" required></textarea><br>

    <input type="submit" name="add" value="Agregar">
  </form>
</body>
</html>
