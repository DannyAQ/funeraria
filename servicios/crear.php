<?php
require '../config.php';

// CREATE: guardar un servicio nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre   = trim($_POST['nombre']);
    $precio   = trim($_POST['precio']);
    $cantidad = trim($_POST['cantidad']);

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

    $nombreArchivo = uniqid('servicio_', true) . '.' . $extension;

    $carpeta = '../img/servicios/';

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

    $rutaBD = '../img/servicios/' . $nombreArchivo;


    $sql = "INSERT INTO servicios (nombre, precio, cantidad, foto)
            VALUES (:nombre, :precio, :cantidad, :foto)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'nombre'   => $nombre,
        'precio'   => $precio,
        'cantidad' => $cantidad,
        'foto'     => $rutaBD
    ]);

    header("Location: index.php?mensaje=Servicio agregado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Nuevo servicio</title>
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <div class="barra">
    <h1>Funeraria</h1>
    <span>Nuevo servicio funerario</span>
  </div>

  <div class="franja"></div>

  <div class="contenedor">

    <h2>Nuevo servicio funerario</h2>

    <form method="post" action="crear.php" enctype="multipart/form-data">

      <label for="nombre">Nombre del servicio</label>
      <input
        type="text"
        id="nombre"
        name="nombre"
        placeholder="Ej: Servicio funerario básico"
        required
      >

      <label for="precio">Valor del servicio</label>
      <input
        type="number"
        id="precio"
        name="precio"
        step="1"
        min="0"
        required
      >

      <label for="cantidad">Cantidad de servicios disponibles</label>
      <input
        type="number"
        id="cantidad"
        name="cantidad"
        step="1"
        min="0"
        required
      >
      <label for="foto">Imagen del servicio</label>
      <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp" required>
      <br>

      <button type="submit">Guardar servicio</button>

      <a class="boton boton-azul" href="index.php">
        Cancelar
      </a>

    </form>

  </div>

</body>
</html>