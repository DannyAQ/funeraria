<?php
require '../config.php';
// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $contacto = trim($_POST['contacto']);
    $ciudad = trim($_POST['ciudad']);

    $sql = "UPDATE proveedores
            SET nombre = :nombre, contacto = :contacto, ciudad = :ciudad
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'contacto' => $contacto,
        'ciudad' => $ciudad,
        'id' => $id
    ]);
    header("Location: index.php?mensaje=Proveedore actualizado");
    exit;
}
// UPDATE parte 2: traer los datos actuales
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM proveedores WHERE id = :id");
$stmt->execute(['id' => $id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Editar proveedor</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1>Funeraria</h1><span>Editar proveedor</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Editar proveedor</h2>
    <form method="post" action="editar.php">
      <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             value="<?php echo htmlspecialchars($r['nombre']); ?>" required>
      <label for="contacto">Contacto</label>
      <input type="text" id="contacto" name="contacto"
             value="<?php echo htmlspecialchars($r['contacto']); ?>" required>
      <label for="ciudad">Ciudad</label>
      <input type="text" id="ciudad" name="ciudad"
             value="<?php echo htmlspecialchars($r['ciudad']); ?>" required>
      <br><button type="submit">Guardar cambios</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
