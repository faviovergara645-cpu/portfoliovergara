# Portafolio — Favio Vergara

## Cómo correrlo en tu PC (XAMPP)

1. Abre XAMPP y pulsa **Start** en **Apache** y **MySQL**.
2. Copia la carpeta `portfoliovergara` dentro de `C:\xampp\htdocs\`.
3. Abre en el navegador: <http://localhost/portfoliovergara/index.html>
   (no abras el `.html` con doble clic: PHP solo funciona a través de `localhost`).
4. Envía el formulario de **Contacto**. La base `portafolio_favio` y la tabla `datos` se crean solas.
   También puedes importar `database.sql` desde phpMyAdmin (<http://localhost/phpmyadmin>).
5. Revisa los mensajes en phpMyAdmin: base `portafolio_favio` > tabla `datos`.

## Si no conecta

- MySQL debe estar en verde en XAMPP. `conexion.php` prueba los puertos 3306 y 3307.
- Si tu `root` tiene contraseña, cámbiala en `conectar_local()` dentro de `conexion.php`.

## Estructura

- `index.html`, `sobre-mi.html`, `galeria.html`, `contacto.html`: páginas.
- `css/estilos.css`: estilos (paleta suave, botones `.btn-fv`, iconos `.icono-red`).
- `js/principal.js`: animación de entrada y visor de imágenes.
- `conexion.php` y `envio.php`: conexión a MySQL y guardado del formulario.
- `img/` y `galeria/`: imágenes.
