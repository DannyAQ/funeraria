<?php
require '../config.php';
// READ: leer todos los registros de gastos
$filas = $pdo->query("SELECT * FROM gastos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
// PROCESAMIENTO: total calculado con SUM
$total = $pdo->query("SELECT SUM(monto) FROM gastos")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Gastos</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1> Funeraria</h1><span>Modulo: Gastos</span></div>
  <div class="franja"></div>
  <div class="menu">
    <a href="../index.php">Inicio</a>
    <a href="../servicios/index.php">Servicios</a>
    <a href="../clientes/index.php">Clientes</a>
    <a href="../empleados/index.php">Empleados</a>
    <a href="../proveedores/index.php">Proveedores</a>
    <a href="../gastos/index.php" class="activo">Gastos</a>
  </div>
  <div class="contenedor">
    <h2>Gastos</h2>
    <a class="boton boton-azul" href="crear.php">+ Nuevo gasto</a>
    <?php if (isset($_GET['mensaje'])): ?>
      <p class="mensaje"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
    <?php endif; ?>
    <table>
      <tr><th>ID</th><th>Concepto</th><th>Monto</th><th>Fecha</th><th>Acciones</th></tr>
      <?php foreach ($filas as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['concepto']); ?></td>
          <td>$ <?php echo number_format($r['monto'], 0, ',', '.'); ?></td>
          <td><?php echo htmlspecialchars($r['fecha']); ?></td>
          <td class="acciones">
            <a href="editar.php?id=<?php echo $r['id']; ?>">Editar</a>
            <a class="borrar" href="eliminar.php?id=<?php echo $r['id']; ?>"
               onclick="return confirm('Eliminar este gasto?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      <tfoot>
        <tr><td colspan="4">Total de gastos</td><td>$ <?php echo number_format($total, 0, ',', '.'); ?></td></tr>
      </tfoot>
    </table>
  </div>
</body>
</html>
