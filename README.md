# Sistema de Administración de Estudiantes

Aplicación web académica para administrar registros de estudiantes mediante un CRUD completo. El sistema permite **crear, consultar, actualizar y eliminar** expedientes estudiantiles, almacenando la información en MySQL o MariaDB mediante PHP y PDO.

> **Objetivo del proyecto:** demostrar el uso de operaciones CRUD con consultas preparadas, sin concatenar variables de entrada directamente en sentencias SQL.

## Funcionalidades

| Operación | Archivo principal | Comportamiento |
|---|---|---|
| Crear | `crear.php` | Valida el formulario y registra un estudiante mediante `INSERT` preparado. |
| Leer | `index.php` | Muestra el listado y permite buscar por identidad, nombre, correo o carrera. |
| Actualizar | `editar.php` | Recupera un registro por su ID y guarda los cambios mediante `UPDATE` preparado. |
| Eliminar | `eliminar.php` | Elimina un registro con `POST`, token CSRF y `DELETE` preparado. |

## Requisitos técnicos

El proyecto necesita **PHP 8.0 o superior**, la extensión `pdo_mysql` habilitada y **MySQL 8+ o MariaDB 10.4+**. Puede ejecutarse en XAMPP, Laragon, WAMP o un servidor PHP equivalente.

| Componente | Uso en el proyecto |
|---|---|
| PHP | Lógica de formularios, validaciones, sesiones y vistas. |
| PDO | Conexión a MySQL y ejecución de sentencias preparadas. |
| MySQL/MariaDB | Persistencia de los expedientes de estudiantes. |
| CSS | Interfaz adaptable para escritorio y dispositivos móviles. |

## Instalación local

1. Copia la carpeta `entrega-sistema-estudiantes` en el directorio público de tu servidor. En XAMPP, normalmente corresponde a `htdocs`.
2. Abre phpMyAdmin o una consola de MySQL e importa el archivo [`database/estudiantes.sql`](database/estudiantes.sql).
3. Revisa [`config/database.php`](config/database.php). Cambia `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` y `DB_PORT` si las credenciales o el puerto de tu equipo son diferentes. XAMPP usa normalmente el puerto `3306`; si está configurado en `3307`, actualiza ese valor.
4. Inicia Apache y MySQL/MariaDB.
5. Abre en tu navegador la ruta del proyecto, por ejemplo: `http://localhost/entrega-sistema-estudiantes/`.

> El script SQL crea la base de datos `sistema_estudiantes`, la tabla `estudiantes` y dos registros iniciales para facilitar la comprobación visual.

## Estructura del proyecto

```text
entrega-sistema-estudiantes/
├── assets/
│   └── css/estilos.css             # Interfaz visual del sistema
├── config/
│   ├── database.php                # Credenciales PDO del entorno local
│   └── database.example.php        # Plantilla de configuración
├── database/
│   └── estudiantes.sql             # Script de creación de BD y tabla
├── includes/
│   ├── encabezado.php               # Encabezado y navegación reutilizables
│   ├── funciones.php                # Validación, sesión, CSRF y utilidades
│   └── pie.php                     # Pie de página reutilizable
├── crear.php                        # Operación CREATE
├── editar.php                       # Operación UPDATE
├── eliminar.php                     # Operación DELETE
├── index.php                        # Operación READ y búsqueda
├── DER.mmd                          # DER editable en Mermaid
├── DER.png                          # DER listo para entregar
└── README.md                         # Descripción, instalación y seguridad del proyecto
```

## Seguridad implementada

| Medida | Implementación |
|---|---|
| Consultas preparadas | Todas las operaciones CRUD utilizan `$pdo->prepare()` y parámetros con nombre. |
| Variables sin concatenación SQL | Los valores del usuario se envían a `execute()` como parámetros, no se insertan dentro de la cadena SQL. |
| Validación de datos | Se valida identidad, correo, teléfono, fecha de nacimiento y longitudes de texto en el servidor. |
| Escape de salida | La función `escapar()` usa `htmlspecialchars()` antes de presentar valores en HTML. |
| Protección CSRF | Las solicitudes que crean, actualizan o eliminan verifican un token de sesión. |
| Errores de base de datos | Se controlan duplicados de identidad/correo y fallos inesperados sin revelar detalles técnicos al usuario. |

## Repositorio GitHub

El código fuente se publica en el siguiente repositorio **público**:

```text
https://github.com/yairg014/sistema-estudiantes-crud
```

Invita como colaboradores a los integrantes del equipo desde **Settings → Collaborators** dentro del repositorio.

## Materiales de entrega incluidos

| Entregable | Archivo |
|---|---|
| Proyecto comprimido | `sistema-estudiantes-crud.zip` |
| Script SQL | `database/estudiantes.sql` |
| DER limpio | `DER.png` y `DER.mmd` |
| README | `README.md` |
| Guion del video | Se prepara y entrega por separado. |
| Documento con portada y enlace | Se prepara y entrega por separado. |
