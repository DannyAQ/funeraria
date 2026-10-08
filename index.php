
<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Funeraria - Inicio</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

  <div class="barra">
    <h1>Funeraria</h1>
    <span>Sistema de registros - Desarrollo Web 1</span>
  </div>

  <div class="franja"></div>

  <div class="menu">
    <a href="index.php" class="activo">Inicio</a>
    <a href="servicios/index.php">Servicios</a>
    <a href="clientes/index.php">Clientes</a>
    <a href="empleados/index.php">Empleados</a>
    <a href="proveedores/index.php">Proveedores</a>
    <a href="gastos/index.php">Gastos</a>
  </div>

  <div class="contenedor">

    <h2>Panel principal</h2>

    <p>
      Bienvenido. Desde el menu se administra cada registro de la funeraria.
    </p>

    <?php

    // PROCESAMIENTO 1: contar cuantos registros hay en cada tabla (COUNT)

    $nServicios  = $pdo->query("SELECT COUNT(*) FROM servicios")->fetchColumn();
    $nClientes   = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
    $nEmpleados  = $pdo->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
    $nProveedores = $pdo->query("SELECT COUNT(*) FROM proveedores")->fetchColumn();
    $nGastos     = $pdo->query("SELECT COUNT(*) FROM gastos")->fetchColumn();


    // PROCESAMIENTO 2: totales calculados con SUM

    $valorServicios = $pdo->query(
      "SELECT SUM(precio * cantidad) FROM servicios"
    )->fetchColumn();

    $totalNomina = $pdo->query(
      "SELECT SUM(salario) FROM empleados"
    )->fetchColumn();

    $totalGastos = $pdo->query(
      "SELECT SUM(monto) FROM gastos"
    )->fetchColumn();

    ?>

    <h3>Cuantos registros hay</h3>

    <div class="tarjetas">

      <div class="tarjeta">
        <div class="num"><?php echo $nServicios; ?></div>
        <div class="et">Servicios</div>
      </div>

      <div class="tarjeta">
        <div class="num"><?php echo $nClientes; ?></div>
        <div class="et">Clientes</div>
      </div>

      <div class="tarjeta">
        <div class="num"><?php echo $nEmpleados; ?></div>
        <div class="et">Empleados</div>
      </div>

      <div class="tarjeta">
        <div class="num"><?php echo $nProveedores; ?></div>
        <div class="et">Proveedores</div>
      </div>

      <div class="tarjeta">
        <div class="num"><?php echo $nGastos; ?></div>
        <div class="et">Gastos</div>
      </div>

    </div>


    <h3>Totales calculados</h3>

    <table>

      <tr>
        <th>Indicador</th>
        <th>Valor</th>
      </tr>

      <tr>
        <td>Ingresos potenciales por servicios</td>
        <td>
          $ <?php echo number_format($valorServicios, 0, ',', '.'); ?>
        </td>
      </tr>

      <tr>
        <td>Total de la nomina mensual</td>
        <td>
          $ <?php echo number_format($totalNomina, 0, ',', '.'); ?>
        </td>
      </tr>

      <tr>
        <td>Total de gastos registrados</td>
        <td>
          $ <?php echo number_format($totalGastos, 0, ',', '.'); ?>
        </td>
      </tr>

    </table>

  </div>

</body>
</html>

