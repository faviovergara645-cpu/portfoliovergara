<?php
require __DIR__ . "/conexion.php";

/** Muestra un aviso y redirige. */
function aviso(string $mensaje, string $destino): void
{
    $flags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    echo '<!doctype html><meta charset="utf-8"><script>alert(' . json_encode($mensaje, $flags) .
         '); window.location.href=' . json_encode($destino, $flags) . ';</script>';
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.html");
    exit;
}

$nombres     = trim($_POST["nombres"] ?? "");
$correo      = trim($_POST["correo"] ?? "");
$comentarios = trim($_POST["comentarios"] ?? "");

if ($nombres === "" || $comentarios === "" || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    aviso("Revisa los datos: completa todos los campos con un correo válido.", "contacto.html");
    exit;
}

$nombres     = mb_substr($nombres, 0, 120);
$correo      = mb_substr($correo, 0, 120);
$comentarios = mb_substr($comentarios, 0, 2000);

try {
    $con = conectar_bd();
} catch (Throwable $e) {
    // En tu PC se muestra el detalle; en el hosting solo un mensaje genérico
    aviso(es_local() ? $e->getMessage() : "No se pudo guardar tu mensaje. Inténtalo más tarde.", "contacto.html");
    exit;
}

$stmt = mysqli_prepare($con, "INSERT INTO datos (nombres, correo, comentarios) VALUES (?, ?, ?)");
if (!$stmt) {
    aviso("Error en la tabla 'datos': " . mysqli_error($con), "contacto.html");
} else {
    mysqli_stmt_bind_param($stmt, "sss", $nombres, $correo, $comentarios);
    if (mysqli_stmt_execute($stmt)) {
        aviso("¡Gracias! Tu mensaje se envió correctamente.", "index.html");
    } else {
        aviso("Problemas al enviar: " . mysqli_stmt_error($stmt), "contacto.html");
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($con);
