$(function () {
    $("body").hide().fadeIn(500);

    /* Abrir el visor al hacer clic en una imagen de la galería */
    $(".img-galeria").on("click", function () {
        const $visor = $('<div class="visor" role="dialog" aria-modal="true" aria-label="Vista ampliada"></div>');
        const $cerrar = $('<button type="button" class="visor-cerrar" aria-label="Cerrar">&times;</button>');
        const $img = $('<img class="visor-img">').attr({ src: this.src, alt: this.alt });
        $visor.append($cerrar, $img);
        $("body").append($visor);
        $cerrar.trigger("focus");
    });

    /* Cerrar con el botón o haciendo clic fuera de la imagen */
    $(document).on("click", ".visor", function (e) {
        if (!$(e.target).is(".visor-img")) { $(".visor").remove(); }
    });

    /* Cerrar con la tecla Escape */
    $(document).on("keyup", function (e) {
        if (e.key === "Escape") { $(".visor").remove(); }
    });
});
