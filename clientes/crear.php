<?php
require '../config.php';
// CREATE: guardar un cliente nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        die('Error al subir la imagen.');
    }

    $tipo = mime_content_type($_FILES['foto']['tmp_name']);

    $tiposPermitidos = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!in_array($tipo, $tiposPermitidos)) {
        die('Solo se permiten imágenes JPG, PNG o WEBP.');
    }

    $tamañoMaximo = 5 * 1024 * 1024;

    if ($_FILES['foto']['size'] > $tamañoMaximo) {
        die('La imagen no puede superar los 5 MB.');
    }

    $extension = match ($tipo) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    };

    $nombreArchivo = uniqid('cliente_', true) . '.' . $extension;

    $carpeta = '../img/clientes/';

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0755, true);
    }

    $rutaArchivo = $carpeta . $nombreArchivo;

    if (!move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        $rutaArchivo
    )) {
        die('No se pudo guardar la imagen.');
    }

    $rutaBD = '../img/clientes/' . $nombreArchivo;

    $sql = "INSERT INTO clientes (nombre, correo, telefono, foto)
            VALUES (:nombre, :correo, :telefono, :foto)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'foto' => $rutaBD
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
    <form method="post" action="crear.php" enctype="multipart/form-data">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" required>
      <label for="correo">Correo</label>
      <input type="email" id="correo" name="correo" required>
      <label for="telefono">Telefono</label>
      <input type="text" id="telefono" name="telefono" required>
      <label for="foto">Imagen del cliente</label>
      <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp" required>
      <br><button type="submit">Guardar</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
