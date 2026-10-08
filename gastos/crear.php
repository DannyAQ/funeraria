<?php
require '../config.php';
// CREATE: guardar un gasto nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $concepto = trim($_POST['concepto']);
    $monto = trim($_POST['monto']);
    $fecha = trim($_POST['fecha']);

    $sql = "INSERT INTO gastos (concepto, monto, fecha)
            VALUES (:concepto, :monto, :fecha)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'concepto' => $concepto,
        'monto' => $monto,
        'fecha' => $fecha
    ]);
    header("Location: index.php?mensaje=Gasto agregado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Nuevo gasto</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1>Funeraria</h1><span>Nuevo gasto</span></div>
  <div class="franja"></div>
  <div class="contenedor">
    <h2>Nuevo gasto</h2>
    <form method="post" action="crear.php">
      <label for="concepto">Concepto</label>
      <input type="text" id="concepto" name="concepto" required>
      <label for="monto">Monto</label>
      <input type="number" id="monto" name="monto" step="1" min="0" required>
      <label for="fecha">Fecha</label>
      <input type="date" id="fecha" name="fecha" required>
      <br><button type="submit">Guardar</button>
      <a class="boton boton-azul" href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>
