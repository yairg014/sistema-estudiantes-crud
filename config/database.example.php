<?php
declare(strict_types=1);

/** Copia este archivo como database.php y ajusta las credenciales de tu entorno. */
const DB_HOST = '127.0.0.1';
const DB_NAME = 'sistema_estudiantes';
// Configuración de desarrollo para XAMPP. Si tu cuenta root tiene clave, escríbela en DB_PASS.
const DB_USER = 'root';
const DB_PASS = '';
const DB_PORT = '3307';
const DB_CHARSET = 'utf8mb4';

function conectarBaseDatos(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST
        . ';port=' . DB_PORT
        . ';dbname=' . DB_NAME
        . ';charset=' . DB_CHARSET;

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
