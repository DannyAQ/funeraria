<?php
require '../config.php';
// DELETE: borrar el empleado por su id
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM empleados WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index.php?mensaje=Empleado eliminado");
exit;
?>
