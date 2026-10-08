
<?php
require '../config.php';

// CREATE: guardar un servicio nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre   = trim($_POST['nombre']);
    $precio   = trim($_POST['precio']);
    $cantidad = trim($_POST['cantidad']);

    $sql = "INSERT INTO servicios (nombre, precio, cantidad)
            VALUES (:nombre, :precio, :cantidad)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'nombre'   => $nombre,
        'precio'   => $precio,
        'cantidad' => $cantidad
    ]);

    header("Location: index.php?mensaje=Servicio agregado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Nuevo servicio</title>
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <div class="barra">
    <h1>Funeraria</h1>
    <span>Nuevo servicio funerario</span>
  </div>

  <div class="franja"></div>

  <div class="contenedor">

    <h2>Nuevo servicio funerario</h2>

    <form method="post" action="crear.php">

      <label for="nombre">Nombre del servicio</label>
      <input
        type="text"
        id="nombre"
        name="nombre"
        placeholder="Ej: Servicio funerario básico"
        required
      >

      <label for="precio">Valor del servicio</label>
      <input
        type="number"
        id="precio"
        name="precio"
        step="1"
        min="0"
        required
      >

      <label for="cantidad">Cantidad de servicios disponibles</label>
      <input
        type="number"
        id="cantidad"
        name="cantidad"
        step="1"
        min="0"
        required
      >

      <br>

      <button type="submit">Guardar servicio</button>

      <a class="boton boton-azul" href="index.php">
        Cancelar
      </a>

    </form>

  </div>

</body>
</html>
