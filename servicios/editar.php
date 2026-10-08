<?php
require '../config.php';

// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'];
    $nombre   = trim($_POST['nombre']);
    $precio   = trim($_POST['precio']);
    $cantidad = trim($_POST['cantidad']);

    // Traer la foto actual por si no se sube una nueva
    $stmt = $pdo->prepare("SELECT foto FROM servicios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $fotoActual = $stmt->fetchColumn();

    $rutaBD = $fotoActual; // por defecto se conserva

    // ¿Se subió una imagen nueva?
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            die('Error al subir la imagen.');
        }

        $tipo = mime_content_type($_FILES['foto']['tmp_name']);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($tipo, $tiposPermitidos)) {
            die('Solo se permiten imágenes JPG, PNG o WEBP.');
        }

        if ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
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

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta . $nombreArchivo)) {
            die('No se pudo guardar la imagen.');
        }

        $rutaBD = '../img/servicios/' . $nombreArchivo;

        // Borrar la foto anterior del servidor
        if ($fotoActual && file_exists($fotoActual)) {
            unlink($fotoActual);
        }
    }

    $sql = "UPDATE servicios
            SET nombre = :nombre, precio = :precio, cantidad = :cantidad, foto = :foto
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre'   => $nombre,
        'precio'   => $precio,
        'cantidad' => $cantidad,
        'foto'     => $rutaBD,
        'id'       => $id
    ]);

    header("Location: index.php?mensaje=Servicio actualizado");
    exit;
}

// UPDATE parte 2: traer los datos actuales
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Falta el id del servicio.');
}

$stmt = $pdo->prepare("SELECT * FROM servicios WHERE id = :id");
$stmt->execute(['id' => $id]);
$a = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$a) {
    die('Servicio no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar servicio</title>
  <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
  <div class="barra">
    <h1>Funeraria</h1>
    <span>Editar servicio funerario</span>
  </div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Editar servicio funerario</h2>
    <form method="post" action="editar.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($a['id']); ?>">

      <label for="nombre">Nombre del servicio</label>
      <input type="text" id="nombre" name="nombre"
             value="<?php echo htmlspecialchars($a['nombre']); ?>" required>

      <label for="precio">Valor del servicio</label>
      <input type="number" id="precio" name="precio" step="1" min="0"
             value="<?php echo htmlspecialchars($a['precio']); ?>" required>

      <label for="cantidad">Cantidad de servicios disponibles</label>
      <input type="number" id="cantidad" name="cantidad" step="1" min="0"
             value="<?php echo htmlspecialchars($a['cantidad']); ?>" required>

      <label>Imagen actual</label><br>
      <?php if (!empty($a['foto'])): ?>
        <img src="<?php echo htmlspecialchars($a['foto']); ?>"
             alt="Imagen de <?php echo htmlspecialchars($a['nombre']); ?>"
             style="max-width:150px; border-radius:8px;">
      <?php else: ?>
        <p>Sin imagen</p>
      <?php endif; ?>
      <br>

      <label for="foto">Cambiar imagen </label>
      <input type="file" id="foto" name="foto"
             accept="image/jpeg,image/png,image/webp">

      <br>
      <button type="submit">Guardar cambios</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>