<?php
require '../config.php';
// DELETE: borrar el cliente por su id
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index.php?mensaje=Cliente eliminado");
exit;
?>
