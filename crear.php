<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/funciones.php';

$estudiante = [
    'identidad' => '',
    'nombres' => '',
    'apellidos' => '',
    'correo' => '',
    'telefono' => '',
    'fecha_nacimiento' => '',
    'carrera' => '',
];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validarTokenCsrf($_POST['csrf_token'] ?? null)) {
        $errores['general'] = 'La solicitud no es válida. Recarga la página e intenta nuevamente.';
    } else {
        $estudiante = obtenerEstudianteDesdeFormulario();
        $errores = validarEstudiante($estudiante);

        if ($errores === []) {
            try {
                $pdo = conectarBaseDatos();
                $sentencia = $pdo->prepare(
                    'INSERT INTO estudiantes (identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera)
                     VALUES (:identidad, :nombres, :apellidos, :correo, :telefono, :fecha_nacimiento, :carrera)'
                );
                $sentencia->execute($estudiante);
                establecerMensaje('exito', 'El estudiante fue registrado correctamente.');
                redirigir('index.php');
            } catch (PDOException $error) {
                if ($error->getCode() === '23000') {
                    $errores['general'] = 'La identidad o el correo ya están registrados.';
                } else {
                    $errores['general'] = 'No fue posible guardar el estudiante. Intenta nuevamente.';
                }
            }
        }
    }
}

$tituloPagina = 'Registrar estudiante';
require __DIR__ . '/includes/encabezado.php';
?>

<section class="hoja-formulario">
    <div class="seccion-cabecera">
        <div>
            <p class="etiqueta-seccion">02 · NUEVO EXPEDIENTE</p>
            <h2>Datos del estudiante</h2>
            <p class="descripcion-seccion">Completa todos los campos. La identidad y el correo no se pueden repetir.</p>
        </div>
        <a class="enlace-volver" href="index.php">← Regresar al listado</a>
    </div>

    <?php if (isset($errores['general'])): ?>
        <div class="mensaje mensaje-error" role="alert"><?= escapar($errores['general']) ?></div>
    <?php endif; ?>

    <form class="formulario-estudiante" action="crear.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= escapar(generarTokenCsrf()) ?>">
        <div class="campos-formulario">
            <div class="campo">
                <label for="identidad">Identidad</label>
                <input id="identidad" name="identidad" type="text" value="<?= escapar($estudiante['identidad']) ?>" placeholder="0801-2000-12345" maxlength="15" required>
                <?php if (isset($errores['identidad'])): ?><small class="error-campo"><?= escapar($errores['identidad']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input id="correo" name="correo" type="email" value="<?= escapar($estudiante['correo']) ?>" placeholder="nombre@correo.com" maxlength="150" required>
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
                <input id="telefono" name="telefono" type="tel" value="<?= escapar($estudiante['telefono']) ?>" placeholder="9999-9999" maxlength="20" required>
                <?php if (isset($errores['telefono'])): ?><small class="error-campo"><?= escapar($errores['telefono']) ?></small><?php endif; ?>
            </div>
            <div class="campo">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" value="<?= escapar($estudiante['fecha_nacimiento']) ?>" required>
                <?php if (isset($errores['fecha_nacimiento'])): ?><small class="error-campo"><?= escapar($errores['fecha_nacimiento']) ?></small><?php endif; ?>
            </div>
            <div class="campo campo-ancho">
                <label for="carrera">Carrera</label>
                <input id="carrera" name="carrera" type="text" value="<?= escapar($estudiante['carrera']) ?>" placeholder="Ejemplo: Ingeniería en Sistemas" maxlength="120" required>
                <?php if (isset($errores['carrera'])): ?><small class="error-campo"><?= escapar($errores['carrera']) ?></small><?php endif; ?>
            </div>
        </div>
        <div class="acciones-formulario">
            <a class="boton boton-terciario" href="index.php">Cancelar</a>
            <button class="boton boton-principal" type="submit">Guardar estudiante</button>
        </div>
    </form>
</section>

<?php require __DIR__ . '/includes/pie.php'; ?>
