<?php
require '../config.php';
// DELETE: borrar el servicio por su id
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM servicios WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index.php?mensaje=Servicio eliminado");
exit;
?>
