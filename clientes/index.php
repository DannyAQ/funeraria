<?php
require '../config.php';
// READ: leer todos los registros de clientes
$filas = $pdo->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Clientes</title>
<link rel="stylesheet" href="../css/estilos.css"></head>
<body>
  <div class="barra"><h1> Funeraria</h1><span>Modulo: Clientes</span></div>
  <div class="franja"></div>
  <div class="menu">
    <a href="../index.php">Inicio</a>
    <a href="../servicios/index.php">Servicios</a>
    <a href="../clientes/index.php" class="activo">Clientes</a>
    <a href="../empleados/index.php">Empleados</a>
    <a href="../proveedores/index.php">Proveedores</a>
    <a href="../gastos/index.php">Gastos</a>
  </div>
  <div class="contenedor">
    <h2>Clientes</h2>
    <a class="boton boton-azul" href="crear.php">+ Nuevo cliente</a>
    <?php if (isset($_GET['mensaje'])): ?>
      <p class="mensaje"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
    <?php endif; ?>
    <table>
      <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Telefono</th><th>Acciones</th></tr>
      <?php foreach ($filas as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['nombre']); ?></td>
          <td><?php echo htmlspecialchars($r['correo']); ?></td>
          <td><?php echo htmlspecialchars($r['telefono']); ?></td>
          <td class="acciones">
            <a href="editar.php?id=<?php echo $r['id']; ?>">Editar</a>
            <a class="borrar" href="eliminar.php?id=<?php echo $r['id']; ?>"
               onclick="return confirm('Eliminar este cliente?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
