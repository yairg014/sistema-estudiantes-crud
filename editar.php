<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/funciones.php';

$id = obtenerIdEntero($_GET['id'] ?? $_POST['id'] ?? null);
if ($id === null) {
    establecerMensaje('error', 'El identificador del estudiante no es válido.');
    redirigir('index.php');
}

$pdo = conectarBaseDatos();
$consulta = $pdo->prepare(
    'SELECT id, identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera
     FROM estudiantes
     WHERE id = :id'
);
$consulta->execute(['id' => $id]);
$estudiante = $consulta->fetch();

if ($estudiante === false) {
    establecerMensaje('error', 'No se encontró el estudiante solicitado.');
    redirigir('index.php');
}

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validarTokenCsrf($_POST['csrf_token'] ?? null)) {
        $errores['general'] = 'La solicitud no es válida. Recarga la página e intenta nuevamente.';
    } else {
        $estudiante = array_merge($estudiante, obtenerEstudianteDesdeFormulario());
        $errores = validarEstudiante($estudiante);

        if ($errores === []) {
            try {
                $sentencia = $pdo->prepare(
                    'UPDATE estudiantes
                     SET identidad = :identidad,
                         nombres = :nombres,
                         apellidos = :apellidos,
                         correo = :correo,
                         telefono = :telefono,
                         fecha_nacimiento = :fecha_nacimiento,
                         carrera = :carrera
                     WHERE id = :id'
                );
                $sentencia->execute([
                    'id' => $id,
                    'identidad' => $estudiante['identidad'],
                    'nombres' => $estudiante['nombres'],
                    'apellidos' => $estudiante['apellidos'],
                    'correo' => $estudiante['correo'],
                    'telefono' => $estudiante['telefono'],
                    'fecha_nacimiento' => $estudiante['fecha_nacimiento'],
                    'carrera' => $estudiante['carrera'],
                ]);
                establecerMensaje('exito', 'Los datos del estudiante se actualizaron correctamente.');
                redirigir('index.php');
            } catch (PDOException $error) {
                if ($error->getCode() === '23000') {
                    $errores['general'] = 'La identidad o el correo ya están asociados a otro estudiante.';
                } else {
                    $errores['general'] = 'No fue posible actualizar el estudiante. Intenta nuevamente.';
                }
            }
        }
    }
}

$tituloPagina = 'Editar estudiante';
require __DIR__ . '/includes/encabezado.php';
?>

<section class="hoja-formulario">
    <div class="seccion-cabecera">
        <div>
            <p class="etiqueta-seccion">03 · EDICIÓN DE EXPEDIENTE</p>
            <h2><?= escapar($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></h2>
            <p class="descripcion-seccion">Modifica los datos necesarios y guarda los cambios del expediente.</p>
        </div>
        <a class="enlace-volver" href="index.php">← Regresar al listado</a>
    </div>

    <?php if (isset($errores['general'])): ?>
        <div class="mensaje mensaje-error" role="alert"><?= escapar($errores['general']) ?></div>
    <?php endif; ?>

    <form class="formulario-estudiante" action="editar.php?id=<?= $id ?>" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= escapar(generarTokenCsrf()) ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="campos-formulario">
            <div class="campo">
                <label for="identidad">Identidad</label>
                <input id="identidad" name="identidad" type="text" value="<?= escapar($estudiante['identidad']) ?>" maxlength="15" required>
                <?php if (isset($errores['identidad'])): ?><small class="error-campo"><?= escapar($errores['identidad']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input id="correo" name="correo" type="email" value="<?= escapar($estudiante['correo']) ?>" maxlength="150" required>
                <?php if (isset($errores['correo'])): ?><small class="error-campo"><?= escapar($errores['correo']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="nombres">Nombres</label>
                <input id="nombres" name="nombres" type="text" value="<?= escapar($estudiante['nombres']) ?>" maxlength="100" required>
                <?php if (isset($errores['nombres'])): ?><small class="error-campo"><?= escapar($errores['nombres']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="apellidos">Apellidos</label>
                <input id="apellidos" name="apellidos" type="text" value="<?= escapar($estudiante['apellidos']) ?>" maxlength="100" required>
                <?php if (isset($errores['apellidos'])): ?><small class="error-campo"><?= escapar($errores['apellidos']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="telefono">Teléfono</label>
                <input id="telefono" name="telefono" type="tel" value="<?= escapar($estudiante['telefono']) ?>" maxlength="20" required>
                <?php if (isset($errores['telefono'])): ?><small class="error-campo"><?= escapar($errores['telefono']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" value="<?= escapar($estudiante['fecha_nacimiento']) ?>" required>
                <?php if (isset($errores['fecha_nacimiento'])): ?><small class="error-campo"><?= escapar($errores['fecha_nacimiento']) ?></small><?php endif; ?>
            </div>
            <div class="campo campo-ancho">
                <label for="carrera">Carrera</label>
                <input id="carrera" name="carrera" type="text" value="<?= escapar($estudiante['carrera']) ?>" maxlength="120" required>
                <?php if (isset($errores['carrera'])): ?><small class="error-campo"><?= escapar($errores['carrera']) ?></small><?php endif; ?>
            </div>
        </div>
        <div class="acciones-formulario">
            <a class="boton boton-terciario" href="index.php">Cancelar</a>
            <button class="boton boton-principal" type="submit">Guardar cambios</button>
        </div>
    </form>
</section>

<?php require __DIR__ . '/includes/pie.php'; ?>
