<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validarTokenCsrf($_POST['csrf_token'] ?? null)) {
    establecerMensaje('error', 'La solicitud para eliminar no es válida.');
    redirigir('index.php');
}

$id = obtenerIdEntero($_POST['id'] ?? null);
if ($id === null) {
    establecerMensaje('error', 'El identificador del estudiante no es válido.');
    redirigir('index.php');
}

try {
    $pdo = conectarBaseDatos();
    $sentencia = $pdo->prepare('DELETE FROM estudiantes WHERE id = :id');
    $sentencia->execute(['id' => $id]);

    if ($sentencia->rowCount() === 1) {
        establecerMensaje('exito', 'El estudiante fue eliminado del sistema.');
    } else {
        establecerMensaje('error', 'El estudiante ya no existe o fue eliminado anteriormente.');
    }
} catch (PDOException $error) {
    establecerMensaje('error', 'No fue posible eliminar el estudiante. Intenta nuevamente.');
}

redirigir('index.php');
