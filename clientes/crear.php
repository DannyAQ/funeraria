<?php
require '../config.php';
// CREATE: guardar un cliente nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    $sql = "INSERT INTO clientes (nombre, correo, telefono)
            VALUES (:nombre, :correo, :telefono)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono
    ]);
    header("Location: index.php?mensaje=Cliente agregado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Nuevo cliente</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1> Funeraria</h1><span>Nuevo cliente</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Nuevo cliente</h2>
    <form method="post" action="crear.php">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" required>
      <label for="correo">Correo</label>
      <input type="email" id="correo" name="correo" required>
      <label for="telefono">Telefono</label>
      <input type="text" id="telefono" name="telefono" required>
      <br><button type="submit">Guardar</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
