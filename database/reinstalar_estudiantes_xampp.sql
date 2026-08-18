-- REINSTALACIÓN LIMPIA PARA XAMPP EN 127.0.0.1:3307
-- Advertencia: este archivo elimina SOLO la tabla estudiantes y sus datos actuales.
-- No elimina otras bases, tablas ni cuentas de MySQL.

CREATE DATABASE IF NOT EXISTS sistema_estudiantes
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sistema_estudiantes;

DROP TABLE IF EXISTS estudiantes;

CREATE TABLE estudiantes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    identidad VARCHAR(15) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    carrera VARCHAR(120) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_estudiantes_identidad UNIQUE (identidad),
    CONSTRAINT uq_estudiantes_correo UNIQUE (correo)
) ENGINE=InnoDB;

INSERT INTO estudiantes (identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera)
VALUES
    ('0801-2001-12345', 'Ana Lucía', 'Martínez López', 'ana.martinez@ejemplo.com', '9999-1200', '2001-04-15', 'Ingeniería en Sistemas'),
    ('0801-2000-54321', 'Carlos Andrés', 'Hernández Cruz', 'carlos.hernandez@ejemplo.com', '9888-4500', '2000-11-20', 'Administración de Empresas');
