# Publicación del proyecto en GitHub

## Objetivo

El repositorio debe ser **público** para que el docente pueda revisar el código, el archivo `README.md` y el DER sin solicitar permisos adicionales.

## Procedimiento recomendado

1. Inicia sesión en [GitHub](https://github.com/) y selecciona **New repository**.
2. Escribe `sistema-estudiantes-crud` como nombre del repositorio y selecciona la visibilidad **Public**.
3. No crees archivos iniciales desde GitHub si vas a subir esta carpeta completa, porque el proyecto ya contiene su propio `README.md`.
4. Desde la carpeta del proyecto, ejecuta los siguientes comandos reemplazando `TU-USUARIO` por el usuario de GitHub del equipo.

```bash
git init
git add .
git commit -m "feat: CRUD de estudiantes con PDO"
git branch -M main
git remote add origin https://github.com/TU-USUARIO/sistema-estudiantes-crud.git
git push -u origin main
```

5. En el repositorio, entra a **Settings → Collaborators → Add people** e invita a cada integrante usando su usuario o correo de GitHub.
6. Copia la URL final del repositorio y reemplaza el marcador de [`DOCUMENTO_ENTREGA.md`](DOCUMENTO_ENTREGA.md).

| Verificación final | Resultado esperado |
|---|---|
| Visibilidad | El repositorio muestra la etiqueta **Public**. |
| Código | Están presentes los archivos PHP, CSS y `database/estudiantes.sql`. |
| Documentación | `README.md`, `DER.png` y `DER.mmd` se visualizan en GitHub. |
| Equipo | Los integrantes aparecen como colaboradores o han aceptado su invitación. |
