<?php
declare(strict_types=1);

/** Copia este archivo como database.php y ajusta las credenciales de tu entorno. */
const DB_HOST = 'localhost';
const DB_NAME = 'sistema_estudiantes';
const DB_USER = 'estudiantes_app';
const DB_PASS = 'CambiarClave2026';
const DB_CHARSET = 'utf8mb4';

function conectarBaseDatos(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
