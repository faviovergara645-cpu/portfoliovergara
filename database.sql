-- Base de datos del formulario de contacto
-- Uso en phpMyAdmin (XAMPP): pestaña "Importar" > elegir este archivo > Continuar.
-- (Opcional: conexion.php ya crea la base y la tabla solo la primera vez que envías el formulario.)
--
-- En InfinityFree no se puede ejecutar CREATE DATABASE: borra las dos primeras
-- sentencias, selecciona tu base en phpMyAdmin e importa solo el CREATE TABLE.

CREATE DATABASE IF NOT EXISTS portafolio_favio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portafolio_favio;

CREATE TABLE IF NOT EXISTS datos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(120) NOT NULL,
    correo VARCHAR(120) NOT NULL,
    comentarios TEXT NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
