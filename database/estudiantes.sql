-- Sistema de Administración de Estudiantes
-- Motor: MySQL 8+ / MariaDB 10.4+
-- Codificación: UTF-8 (utf8mb4)
-- Destino de esta entrega: XAMPP/MySQL en 127.0.0.1:3307.

CREATE DATABASE IF NOT EXISTS sistema_estudiantes
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Este script no ejecuta CREATE USER ni GRANT. Así evita depender de las tablas
-- internas de privilegios cuando XAMPP presenta errores de Aria. El CRUD se conecta
-- con la cuenta administradora local definida en config/database.php.

USE sistema_estudiantes;

CREATE TABLE IF NOT EXISTS estudiantes (
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

-- Datos iniciales opcionales para probar la visualización del sistema.
INSERT INTO estudiantes (identidad, nombres, apellidos, correo, telefono, fecha_nacimiento, carrera)
VALUES
    ('0801-2001-12345', 'Ana Lucía', 'Martínez López', 'ana.martinez@ejemplo.com', '9999-1200', '2001-04-15', 'Ingeniería en Sistemas'),
    ('0801-2000-54321', 'Carlos Andrés', 'Hernández Cruz', 'carlos.hernandez@ejemplo.com', '9888-4500', '2000-11-20', 'Administración de Empresas')
ON DUPLICATE KEY UPDATE identidad = VALUES(identidad);
