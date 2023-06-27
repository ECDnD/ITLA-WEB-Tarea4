<!DOCTYPE html>
<html>
<head>
  <title>Editar Personaje</title>
</head>
<body>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
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

    // Obtener el ID del personaje a editar
    $id = $_GET['id'];

    // Obtener los datos del personaje a editar
    $sql = "SELECT * FROM characters WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    // Mostrar el formulario con los datos actuales del personaje
    ?>
    <h2>Editar Personaje</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required><br>

      <label for="anime">Anime:</label>
      <input type="text" name="anime" value="<?php echo $row['anime']; ?>" required><br>

      <label for="description">Descripción:</label><br>
      <textarea name="description" rows="4" cols="50" required><?php echo $row['description']; ?></textarea><br>

      <input type="submit" name="edit" value="Guardar cambios">
    </form>

    <?php
    // Modificar personaje
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
      $id = $_POST['id'];
      $nombre = clean_input($_POST['nombre']);
      $anime = clean_input($_POST['anime']);
      $description = clean_input($_POST['description']);

      $sql = "UPDATE characters SET nombre='$nombre', anime='$anime', description='$description' WHERE id=$id";
      if ($conn->query($sql) === TRUE) {
        echo "Personaje modificado exitosamente.";
      } else {
        echo "Error al modificar el personaje: " . $conn->error;
      }
    }
    $conn->close();
  } else {
    // Si no se envió el formulario, mostrar un mensaje de error
    echo "Acceso no válido.";
  }


  ?>
</body>
</html>