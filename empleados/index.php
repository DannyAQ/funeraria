<?php
require '../config.php';
// READ: leer todos los registros de empleados
$filas = $pdo->query("SELECT * FROM empleados ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
// PROCESAMIENTO: total calculado con SUM
$total = $pdo->query("SELECT SUM(salario) FROM empleados")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Empleados</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1> Funeraria</h1><span>Modulo: Empleados</span></div>
  <div class="franja"></div>
  <div class="menu">
    <a href="../index.php">Inicio</a>
    <a href="../servicios/index.php">Servicios</a>
    <a href="../clientes/index.php">Clientes</a>
    <a href="../empleados/index.php" class="activo">Empleados</a>
    <a href="../proveedores/index.php">Proveedores</a>
    <a href="../gastos/index.php">Gastos</a>
  </div>
  <div class="contenedor">
    <h2>Empleados</h2>
    <a class="boton boton-azul" href="crear.php">+ Nuevo empleado</a>
    <?php if (isset($_GET['mensaje'])): ?>
      <p class="mensaje"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
    <?php endif; ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Cargo</th>
        <th>Salario</th>
        <th>Acciones</th>
      </tr>

      <?php foreach ($filas as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>

          <td>
            <img src=<?php echo htmlspecialchars($r['foto']); ?>
                 alt="Foto del empleado"
                 width="80"
                 height="80">
          </td>

          <td><?php echo htmlspecialchars($r['nombre']); ?></td>
          <td><?php echo htmlspecialchars($r['cargo']); ?></td>
          <td>$ <?php echo number_format($r['salario'], 0, ',', '.'); ?></td>

          <td class="acciones">
            <a href="editar.php?id=<?php echo $r['id']; ?>">Editar</a>
            <a class="borrar" href="eliminar.php?id=<?php echo $r['id']; ?>"
               onclick="return confirm('Eliminar este empleado?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>

      </tfoot>
        <tr><td colspan="4">Total de la nomina mensual</td><td>$ <?php echo number_format($total, 0, ',', '.'); ?></td></tr>
      </tfoot>
    </table>
  </div>
</body>
</html>
