
<?php
require '../config.php';

// UPDATE parte 1: guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id       = $_POST['id'];
    $nombre   = trim($_POST['nombre']);
    $precio   = trim($_POST['precio']);
    $cantidad = trim($_POST['cantidad']);

    $sql = "UPDATE servicios
            SET nombre = :nombre, precio = :precio, cantidad = :cantidad
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'nombre'   => $nombre,
        'precio'   => $precio,
        'cantidad' => $cantidad,
        'id'       => $id
    ]);

    header("Location: index.php?mensaje=Servicio actualizado");
    exit;
}

// UPDATE parte 2: traer los datos actuales
$id = $_GET['id'];

$stmt = $pdo->prepare(
    "SELECT * FROM servicios WHERE id = :id"
);

$stmt->execute([
    'id' => $id
]);

$a = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Editar servicio</title>
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <div class="barra">
    <h1>Funeraria</h1>
    <span>Editar servicio funerario</span>
  </div>

  <div class="franja"></div>

  <div class="contenedor">

    <h2>Editar servicio funerario</h2>

    <form method="post" action="editar.php">

      <input
        type="hidden"
        name="id"
        value="<?php echo $a['id']; ?>"
      >

      <label for="nombre">Nombre del servicio</label>

      <input
        type="text"
        id="nombre"
        name="nombre"
        value="<?php echo htmlspecialchars($a['nombre']); ?>"
        required
      >

      <label for="precio">Valor del servicio</label>

      <input
        type="number"
        id="precio"
        name="precio"
        step="1"
        min="0"
        value="<?php echo htmlspecialchars($a['precio']); ?>"
        required
      >

      <label for="cantidad">Cantidad de servicios disponibles</label>

      <input
        type="number"
        id="cantidad"
        name="cantidad"
        step="1"
        min="0"
        value="<?php echo htmlspecialchars($a['cantidad']); ?>"
        required
      >

      <br>

      <button type="submit">Guardar cambios</button>

      <a class="boton boton-azul" href="index.php">
        Cancelar
      </a>

    </form>

  </div>

</body>
</html>
