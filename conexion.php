<?php
/**
 * conexion.php
 * Conexión a MySQL.
 *  - En tu PC (XAMPP + phpMyAdmin): usa root sin contraseña y crea la base y la tabla solas.
 *  - En InfinityFree: usa los datos del hosting (la base ya existe, solo se crea la tabla).
 */

mysqli_report(MYSQLI_REPORT_OFF);

const NOMBRE_BD_LOCAL = "portafolio_favio";

function es_local(): bool
{
    $servidor = $_SERVER["SERVER_NAME"] ?? "localhost";
    return in_array($servidor, ["localhost", "127.0.0.1", "::1"], true) || PHP_SAPI === "cli";
}

/** Devuelve la conexión lista para usar o lanza RuntimeException con el motivo. */
function conectar_bd(): mysqli
{
    if (es_local()) {
        $con = conectar_local();
    } else {
        $con = conectar_remoto();
    }

    mysqli_set_charset($con, "utf8mb4");
    crear_tabla($con);
    return $con;
}

function conectar_local(): mysqli
{
    $usuario = "root";
    $clave   = "";            // XAMPP trae root sin contraseña
    $hosts   = ["127.0.0.1", "localhost"];
    $puertos = [3306, 3307];  // 3307 es el que usa XAMPP cuando 3306 está ocupado

    $ultimoError = "";
    foreach ($hosts as $host) {
        foreach ($puertos as $puerto) {
            $con = @mysqli_connect($host, $usuario, $clave, null, $puerto);
            if ($con) {
                $bd = NOMBRE_BD_LOCAL;
                if (!mysqli_query($con, "CREATE DATABASE IF NOT EXISTS `$bd` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
                    throw new RuntimeException("No se pudo crear la base '$bd': " . mysqli_error($con));
                }
                if (!mysqli_select_db($con, $bd)) {
                    throw new RuntimeException("No se pudo seleccionar la base '$bd': " . mysqli_error($con));
                }
                return $con;
            }
            $ultimoError = mysqli_connect_error();
        }
    }

    throw new RuntimeException(
        "No se pudo conectar a MySQL (probé los puertos 3306 y 3307). " .
        "Abre el panel de XAMPP y pulsa Start en MySQL. Detalle: " . $ultimoError
    );
}

function conectar_remoto(): mysqli
{
    // Datos de InfinityFree (panel del hosting > MySQL Databases)
    $host  = "sql212.infinityfree.com";
    $user  = "if0_43474141";
    $clave = "IcenifjaOCkDPof";
    $bd    = "if0_43474141_portafoliojc"; // cambia el final si creaste la base con otro nombre

    $con = @mysqli_connect($host, $user, $clave, $bd);
    if (!$con) {
        error_log("Conexión remota fallida: " . mysqli_connect_error());
        throw new RuntimeException("No se pudo conectar a la base de datos del servidor.");
    }
    return $con;
}

function crear_tabla(mysqli $con): void
{
    $sql = "CREATE TABLE IF NOT EXISTS datos (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nombres VARCHAR(120) NOT NULL,
                correo VARCHAR(120) NOT NULL,
                comentarios TEXT NOT NULL,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!mysqli_query($con, $sql)) {
        throw new RuntimeException("No se pudo preparar la tabla 'datos': " . mysqli_error($con));
    }
}
