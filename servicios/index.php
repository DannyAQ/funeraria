
<?php
require '../config.php';

// READ: leer todos los servicios
$servicios = $pdo->query(
    "SELECT * FROM servicios ORDER BY id DESC"
)->fetchAll(PDO::FETCH_ASSOC);

// PROCESAMIENTO: valor total de los servicios (SUM de precio * cantidad)
$total = $pdo->query(
    "SELECT SUM(precio * cantidad) FROM servicios"
)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Servicios funerarios</title>
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <div class="barra">
    <h1>Funeraria</h1>
    <span>Modulo: Servicios funerarios</span>
  </div>

  <div class="franja"></div>

  <div class="menu">
    <a href="../index.php">Inicio</a>
    <a href="index.php" class="activo">Servicios</a>
    <a href="../clientes/index.php">Clientes</a>
    <a href="../empleados/index.php">Empleados</a>
    <a href="../proveedores/index.php">Proveedores</a>
    <a href="../gastos/index.php">Gastos</a>
  </div>

  <div class="contenedor">

    <h2>Servicios funerarios</h2>

    <a class="boton boton-azul" href="crear.php">
      + Nuevo servicio
    </a>

    <?php if (isset($_GET['mensaje'])): ?>
      <p class="mensaje">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
      </p>
    <?php endif; ?>

    <table>

      <tr>
        <th>ID</th>
        <th>Foto</th>
        <th>Servicio</th>
        <th>Valor</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
        <th>Acciones</th>
      </tr>

      <?php foreach ($servicios as $s): ?>

        <tr>

          <td>
            <?php echo $s['id']; ?>
          </td>
          
          <td>
            <img src=<?php echo htmlspecialchars($s['foto']); ?>
                 alt="Foto del servicio"
                 width="100"
                 height="100">
          </td>


          <td>
            <?php echo htmlspecialchars($s['nombre']); ?>
          </td>

          <td>
            $ <?php echo number_format($s['precio'], 0, ',', '.'); ?>
          </td>

          <td>
            <?php echo $s['cantidad']; ?>
          </td>

          <td>
            $ <?php echo number_format(
                $s['precio'] * $s['cantidad'],
                0,
                ',',
                '.'
            ); ?>
          </td>

          <td class="acciones">

            <a href="editar.php?id=<?php echo $s['id']; ?>">
              Editar
            </a>

            <a
              class="borrar"
              href="eliminar.php?id=<?php echo $s['id']; ?>"
              onclick="return confirm('¿Eliminar este servicio?');"
            >
              Eliminar
            </a>

          </td>

        </tr>

      <?php endforeach; ?>

      <tfoot>

        <tr>
          <td colspan="4">
            Valor total de los servicios registrados
          </td>

          <td colspan="2">
            $ <?php echo number_format($total, 0, ',', '.'); ?>
          </td>
        </tr>

      </tfoot>

    </table>

  </div>

</body>
</html>
