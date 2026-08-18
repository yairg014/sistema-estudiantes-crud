# Guion para video explicativo

## Sistema de Administración de Estudiantes — Duración objetivo: 2 min 35 s

> Antes de grabar, inicia Apache y MySQL/MariaDB, importa el script `database/estudiantes.sql` y abre el sistema en el navegador. Graba únicamente datos de demostración, no información real de estudiantes.

| Tiempo | Acción en pantalla | Guion sugerido |
|---:|---|---|
| 0:00–0:15 | Muestra la pantalla principal y el listado. | “Este es el Sistema de Administración de Estudiantes. Fue desarrollado con PHP, MySQL y PDO para realizar las operaciones CRUD de forma segura.” |
| 0:15–0:35 | Señala la tabla, el buscador y los datos ya registrados. | “En la pantalla inicial se visualizan los estudiantes registrados. También se puede buscar por identidad, nombre, correo o carrera.” |
| 0:35–1:05 | Presiona **Registrar estudiante**, completa los campos y guarda. | “Para crear un registro selecciono Registrar estudiante. El formulario valida los datos obligatorios, como identidad, correo, teléfono, fecha de nacimiento y carrera.” |
| 1:05–1:25 | Muestra el mensaje de éxito y el nuevo registro en la tabla. | “Al guardar, el nuevo estudiante aparece en la lista. La inserción se realiza mediante una consulta preparada de PDO.” |
| 1:25–1:50 | Busca el estudiante recién creado y pulsa **Editar**. Modifica un dato y guarda. | “Ahora utilizo Editar para actualizar la información del expediente. El sistema recupera el estudiante por su identificador y actualiza los cambios de forma segura.” |
| 1:50–2:10 | Pulsa **Eliminar**, confirma y muestra la lista actualizada. | “Para eliminar un registro, el sistema solicita confirmación y procesa la petición por POST. El registro se elimina usando una consulta preparada.” |
| 2:10–2:35 | Abre rápidamente `README.md`, `DER.png` y `database/estudiantes.sql`. | “Finalmente, el proyecto incluye el README, el diagrama entidad-relación y el script SQL. Todas las operaciones usan PDO con parámetros enlazados; no se concatenan variables en las consultas SQL.” |

## Lista de comprobación antes de publicar el video

| Revisión | Confirmación |
|---|---|
| Duración | El video no supera 3 minutos. |
| Demostración | Se muestran Crear, Leer, Actualizar y Eliminar. |
| Seguridad | Se explica el uso de PDO y consultas preparadas. |
| Entregables | Se menciona el DER, el script SQL y el README. |
| Enlace | Se sube a Google Drive o YouTube y se verifica que el docente pueda abrirlo. |
