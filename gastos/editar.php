<?php
require '../config.php';
// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $concepto = trim($_POST['concepto']);
    $monto = trim($_POST['monto']);
    $fecha = trim($_POST['fecha']);

    $sql = "UPDATE gastos
            SET concepto = :concepto, monto = :monto, fecha = :fecha
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'concepto' => $concepto,
        'monto' => $monto,
        'fecha' => $fecha,
        'id' => $id
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
    <form method="post" action="editar.php">
      <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
      <label for="concepto">Concepto</label>
      <input type="text" id="concepto" name="concepto"
             value="<?php echo htmlspecialchars($r['concepto']); ?>" required>
      <label for="monto">Monto</label>
      <input type="number" id="monto" name="monto" step="1" min="0"
             value="<?php echo htmlspecialchars($r['monto']); ?>" required>
      <label for="fecha">Fecha</label>
      <input type="date" id="fecha" name="fecha"
             value="<?php echo htmlspecialchars($r['fecha']); ?>" required>
      <br><button type="submit">Guardar cambios</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
