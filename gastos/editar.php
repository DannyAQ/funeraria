<?php
require '../config.php';

// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'];
    $concepto = trim($_POST['concepto']);
    $monto    = trim($_POST['monto']);
    $fecha    = trim($_POST['fecha']);

    // Traer la foto actual por si no se sube una nueva
    $stmt = $pdo->prepare("SELECT foto FROM gastos WHERE id = :id");
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

        $nombreArchivo = uniqid('gasto_', true) . '.' . $extension;
        $carpeta = '../img/gastos/';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta . $nombreArchivo)) {
            die('No se pudo guardar la imagen.');
        }

        $rutaBD = '../img/gastos/' . $nombreArchivo;

        // Borrar la foto anterior del servidor
        if ($fotoActual && file_exists($fotoActual)) {
            unlink($fotoActual);
        }
    }

    $sql = "UPDATE gastos
            SET concepto = :concepto, monto = :monto, fecha = :fecha, foto = :foto
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'concepto' => $concepto,
        'monto'    => $monto,
        'fecha'    => $fecha,
        'foto'     => $rutaBD,
        'id'       => $id
    ]);

    header("Location: index.php?mensaje=Gasto actualizado");
    exit;
}

// UPDATE parte 2: traer los datos actuales
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = :id");
$stmt->execute(['id' => $id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Editar gasto</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1>Funeraria</h1><span>Editar gasto</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Editar gasto</h2>
    <form method="post" action="editar.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">

      <label for="concepto">Concepto</label>
      <input type="text" id="concepto" name="concepto"
             value="<?php echo htmlspecialchars($r['concepto']); ?>" required>

      <label for="monto">Monto</label>
      <input type="number" id="monto" name="monto" step="1" min="0"
             value="<?php echo htmlspecialchars($r['monto']); ?>" required>

      <label for="fecha">Fecha</label>
      <input type="date" id="fecha" name="fecha"
             value="<?php echo htmlspecialchars($r['fecha']); ?>" required>

      <label>Imagen actual (comprobante)</label><br>
      <?php if (!empty($r['foto'])): ?>
        <img src="<?php echo htmlspecialchars($r['foto']); ?>"
             alt="Imagen del gasto"
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