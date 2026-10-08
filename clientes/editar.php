<?php
require '../config.php';

// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'];
    $nombre   = trim($_POST['nombre']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    // Traer la foto actual por si no se sube una nueva
    $stmt = $pdo->prepare("SELECT foto FROM clientes WHERE id = :id");
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

        $nombreArchivo = uniqid('cliente_', true) . '.' . $extension;
        $carpeta = '../img/clientes/';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        $rutaArchivo = $carpeta . $nombreArchivo;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaArchivo)) {
            die('No se pudo guardar la imagen.');
        }

        $rutaBD = '../img/clientes/' . $nombreArchivo;

        // Borrar la foto anterior del servidor
        if ($fotoActual && file_exists($fotoActual)) {
            unlink($fotoActual);
        }
    }

    $sql = "UPDATE clientes
            SET nombre = :nombre, correo = :correo, telefono = :telefono, foto = :foto
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre'   => $nombre,
        'correo'   => $correo,
        'telefono' => $telefono,
        'foto'     => $rutaBD,
        'id'       => $id
    ]);

    header("Location: index.php?mensaje=Cliente actualizado");
    exit;
}

// UPDATE parte 2: traer los datos actuales
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute(['id' => $id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Editar cliente</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1>Funeraria</h1><span>Editar cliente</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Editar cliente</h2>
    <form method="post" action="editar.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">

      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             value="<?php echo htmlspecialchars($r['nombre']); ?>" required>

      <label for="correo">Correo</label>
      <input type="email" id="correo" name="correo"
             value="<?php echo htmlspecialchars($r['correo']); ?>" required>

      <label for="telefono">Teléfono</label>
      <input type="text" id="telefono" name="telefono"
             value="<?php echo htmlspecialchars($r['telefono']); ?>" required>

      <label>Imagen actual</label><br>
      <?php if (!empty($r['foto'])): ?>
        <img src="<?php echo htmlspecialchars($r['foto']); ?>"
             alt="Foto de <?php echo htmlspecialchars($r['nombre']); ?>"
             style="max-width:150px; border-radius:8px;">
      <?php else: ?>
        <p>Sin imagen</p>
      <?php endif; ?>
      <br>

      <label for="foto">Cambiar imagen (opcional)</label>
      <input type="file" id="foto" name="foto"
             accept="image/jpeg,image/png,image/webp">

      <br><button type="submit">Guardar cambios</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>