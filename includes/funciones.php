<?php
declare(strict_types=1);

function escapar(?string $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function redirigir(string $ruta): never
{
    header('Location: ' . $ruta);
    exit;
}

function establecerMensaje(string $tipo, string $texto): void
{
    $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
}

function obtenerMensaje(): ?array
{
    if (!isset($_SESSION['mensaje'])) {
        return null;
    }

    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);

    return $mensaje;
}

function generarTokenCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarTokenCsrf(?string $token): bool
{
    return isset($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

function obtenerEstudianteDesdeFormulario(): array
{
    return [
        'identidad' => trim((string) ($_POST['identidad'] ?? '')),
        'nombres' => trim((string) ($_POST['nombres'] ?? '')),
        'apellidos' => trim((string) ($_POST['apellidos'] ?? '')),
        'correo' => trim((string) ($_POST['correo'] ?? '')),
        'telefono' => trim((string) ($_POST['telefono'] ?? '')),
        'fecha_nacimiento' => trim((string) ($_POST['fecha_nacimiento'] ?? '')),
        'carrera' => trim((string) ($_POST['carrera'] ?? '')),
    ];
}

function longitudTexto(string $valor): int
{
    return function_exists('mb_strlen') ? mb_strlen($valor) : strlen($valor);
}

function validarEstudiante(array $estudiante): array
{
    $errores = [];

    if ($estudiante['identidad'] === '' || !preg_match('/^[0-9]{4}-?[0-9]{4}-?[0-9]{5}$/', $estudiante['identidad'])) {
        $errores['identidad'] = 'Ingresa una identidad válida (por ejemplo, 0801-2000-12345).';
    }

    if ($estudiante['nombres'] === '' || longitudTexto($estudiante['nombres']) > 100) {
        $errores['nombres'] = 'Los nombres son obligatorios y deben tener máximo 100 caracteres.';
    }

    if ($estudiante['apellidos'] === '' || longitudTexto($estudiante['apellidos']) > 100) {
        $errores['apellidos'] = 'Los apellidos son obligatorios y deben tener máximo 100 caracteres.';
    }

    if ($estudiante['correo'] === '' || !filter_var($estudiante['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'Ingresa un correo electrónico válido.';
    }

    if ($estudiante['telefono'] === '' || !preg_match('/^[0-9+() -]{8,20}$/', $estudiante['telefono'])) {
        $errores['telefono'] = 'Ingresa un teléfono válido.';
    }

    $fecha = DateTime::createFromFormat('Y-m-d', $estudiante['fecha_nacimiento']);
    if (!$fecha || $fecha->format('Y-m-d') !== $estudiante['fecha_nacimiento'] || $fecha > new DateTime('today')) {
        $errores['fecha_nacimiento'] = 'Ingresa una fecha de nacimiento válida.';
    }

    if ($estudiante['carrera'] === '' || longitudTexto($estudiante['carrera']) > 120) {
        $errores['carrera'] = 'La carrera es obligatoria y debe tener máximo 120 caracteres.';
    }

    return $errores;
}

function obtenerIdEntero(?string $valor): ?int
{
    $id = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}
