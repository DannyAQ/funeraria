<?php
require '../config.php';
// DELETE: borrar el gasto por su id
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM gastos WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index.php?mensaje=Gasto eliminado");
exit;
?>
