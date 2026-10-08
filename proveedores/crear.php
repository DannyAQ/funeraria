<?php
require '../config.php';
// CREATE: guardar un proveedor nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $contacto = trim($_POST['contacto']);
    $ciudad = trim($_POST['ciudad']);

    $sql = "INSERT INTO proveedores (nombre, contacto, ciudad)
            VALUES (:nombre, :contacto, :ciudad)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'contacto' => $contacto,
        'ciudad' => $ciudad
    ]);
    header("Location: index.php?mensaje=Proveedore agregado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Nuevo proveedor</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1>Funeraria</h1><span>Nuevo proveedor</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Nuevo proveedor</h2>
    <form method="post" action="crear.php">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" required>
      <label for="contacto">Contacto</label>
      <input type="text" id="contacto" name="contacto" required>
      <label for="ciudad">Ciudad</label>
      <input type="text" id="ciudad" name="ciudad" required>
      <br><button type="submit">Guardar</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
