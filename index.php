<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/funciones.php';

$pdo = conectarBaseDatos();
$busqueda = trim((string) ($_GET['buscar'] ?? ''));

if ($busqueda === '') {
    $consulta = $pdo->prepare(
        'SELECT id, identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera, created_at
         FROM estudiantes
         ORDER BY id DESC'
    );
    $consulta->execute();
} else {
    $consulta = $pdo->prepare(
        'SELECT id, identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera, created_at
         FROM estudiantes
         WHERE identidad LIKE :busqueda
            OR nombres LIKE :busqueda
            OR apellidos LIKE :busqueda
            OR correo LIKE :busqueda
            OR carrera LIKE :busqueda
         ORDER BY id DESC'
    );
    $consulta->execute(['busqueda' => '%' . $busqueda . '%']);
}

$estudiantes = $consulta->fetchAll();
$total = count($estudiantes);
$tituloPagina = 'Expedientes de estudiantes';
require __DIR__ . '/includes/encabezado.php';
?>

<section class="panel-resumen" aria-label="Resumen de registros">
    <div class="resumen-destacado">
        <p class="etiqueta-seccion">01 · REGISTROS ACTIVOS</p>
        <strong><?= $total ?></strong>
        <span><?= $busqueda === '' ? 'Estudiantes mostrados en el registro.' : 'Coincidencias para la búsqueda actual.' ?></span>
    </div>
    <div class="resumen-nota">
        <p>La identidad y el correo se mantienen como datos únicos para evitar expedientes duplicados.</p>
    </div>
</section>

<section class="mesa-registros">
    <div class="seccion-cabecera">
        <div>
            <p class="etiqueta-seccion">02 · CONSULTA</p>
            <h2>Lista de estudiantes</h2>
        </div>
        <form class="buscador" action="index.php" method="get">
            <label class="solo-lectura" for="buscar">Buscar estudiantes</label>
            <input id="buscar" name="buscar" type="search" value="<?= escapar($busqueda) ?>" placeholder="Nombre, identidad o carrera">
            <button class="boton boton-secundario" type="submit">Buscar</button>
            <?php if ($busqueda !== ''): ?>
                <a class="enlace-limpio" href="index.php">Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($estudiantes === []): ?>
        <div class="estado-vacio">
            <span class="ficha-mini" aria-hidden="true"></span>
            <h3>No hay estudiantes para mostrar</h3>
            <p><?= $busqueda === '' ? 'Crea el primer expediente para comenzar la administración académica.' : 'Prueba otra búsqueda o regresa al listado completo.' ?></p>
            <a class="boton boton-principal" href="<?= $busqueda === '' ? 'crear.php' : 'index.php' ?>">
                <?= $busqueda === '' ? 'Registrar estudiante' : 'Ver todos los registros' ?>
            </a>
        </div>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Identidad</th>
                        <th>Contacto</th>
                        <th>Carrera</th>
                        <th class="acciones-columna">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <tr>
                            <td>
                                <strong><?= escapar($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></strong>
                                <small>Nacimiento: <?= escapar(date('d/m/Y', strtotime($estudiante['fecha_nacimiento']))) ?></small>
                            </td>
                            <td><?= escapar($estudiante['identidad']) ?></td>
                            <td>
                                <a href="mailto:<?= escapar($estudiante['correo']) ?>"><?= escapar($estudiante['correo']) ?></a>
                                <small><?= escapar($estudiante['telefono']) ?></small>
                            </td>
                            <td><span class="etiqueta-carrera"><?= escapar($estudiante['carrera']) ?></span></td>
                            <td class="acciones">
                                <a class="accion-editar" href="editar.php?id=<?= (int) $estudiante['id'] ?>">Editar</a>
                                <form action="eliminar.php" method="post" onsubmit="return confirm('¿Deseas eliminar este estudiante? Esta acción no se puede deshacer.');">
                                    <input type="hidden" name="csrf_token" value="<?= escapar(generarTokenCsrf()) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $estudiante['id'] ?>">
                                    <button class="accion-eliminar" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/pie.php'; ?>
