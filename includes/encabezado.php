<?php
declare(strict_types=1);

if (!isset($tituloPagina)) {
    $tituloPagina = 'Sistema de Estudiantes';
}

$paginaActual = basename($_SERVER['PHP_SELF']);
$mensaje = obtenerMensaje();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema seguro de administración de estudiantes con PHP, MySQL y PDO.">
    <title><?= escapar($tituloPagina) ?> | Sistema de Estudiantes</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <div class="aplicacion">
        <aside class="barra-lateral" aria-label="Navegación principal">
            <a class="marca" href="index.php" aria-label="Ir al listado de estudiantes">
                <span class="marca-simbolo" aria-hidden="true"><span></span></span>
                <span><strong>Registro</strong><small>Académico</small></span>
            </a>
            <nav class="navegacion">
                <a class="<?= $paginaActual === 'index.php' ? 'activo' : '' ?>" href="index.php">01 · Estudiantes</a>
                <a class="<?= $paginaActual === 'crear.php' ? 'activo' : '' ?>" href="crear.php">02 · Nuevo registro</a>
            </nav>
            <div class="nota-seguridad">
                <span>PDO</span>
                <p>Consultas preparadas activas. Los datos se procesan con parámetros enlazados.</p>
            </div>
        </aside>

        <main class="contenido-principal">
            <header class="cabecera">
                <div>
                    <p class="etiqueta-seccion">SISTEMA DE GESTIÓN · 2026</p>
                    <h1><?= escapar($tituloPagina) ?></h1>
                </div>
                <a class="boton boton-principal" href="crear.php">+ Registrar estudiante</a>
            </header>

            <?php if ($mensaje !== null): ?>
                <div class="mensaje mensaje-<?= escapar($mensaje['tipo']) ?>" role="status">
                    <?= escapar($mensaje['texto']) ?>
                </div>
            <?php endif; ?>
