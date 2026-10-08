<?php
require '../config.php';
// DELETE: borrar el proveedor por su id
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM proveedores WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index.php?mensaje=Proveedor eliminado");
exit;
?>
