<?php
// ============================================================
// Conexion a la base de datos SQLite con PDO
// SQLite guarda TODO en un solo archivo: db/funeraria.sqlite
// No hay servidor, usuario ni contrasenia.
// ============================================================

$archivoBase = __DIR__ . '/db/funeraria.sqlite';
$primeraVez  = !file_exists($archivoBase);   // la primera vez se carga el esquema

try {
    // La cadena de conexion de SQLite es "sqlite:" + la ruta del archivo
    $pdo = new PDO('sqlite:' . $archivoBase);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // La primera vez, crear las tablas desde el script esquema.sql
    if ($primeraVez) {
        $pdo->exec(file_get_contents(__DIR__ . '/db/esquema.sql'));
    }
} catch (PDOException $e) {
    die('Error de conexion: ' . $e->getMessage());
}
