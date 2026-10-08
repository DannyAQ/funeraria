<?php
require '../config.php';
// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    $sql = "UPDATE clientes
            SET nombre = :nombre, correo = :correo, telefono = :telefono
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'id' => $id
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
  <div class="barra"><h1> Funeraria</h1><span>Editar cliente</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Editar cliente</h2>
    <form method="post" action="editar.php">
      <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             value="<?php echo htmlspecialchars($r['nombre']); ?>" required>
      <label for="correo">Correo</label>
      <input type="email" id="correo" name="correo"
             value="<?php echo htmlspecialchars($r['correo']); ?>" required>
      <label for="telefono">Telefono</label>
      <input type="text" id="telefono" name="telefono"
             value="<?php echo htmlspecialchars($r['telefono']); ?>" required>
      <br><button type="submit">Guardar cambios</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
