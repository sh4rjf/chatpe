<?php
// Función para agregar el botón de ChatPe en el contenido del sitio
function agregar_boton_chatpe_al_contenido($content) {
    if (is_singular()) {
        $content .= mostrar_boton_chatpe();
    }
    return $content;
}
add_filter('the_content', 'agregar_boton_chatpe_al_contenido');

// Función para mostrar el botón de ChatPe
function mostrar_boton_chatpe() {
    $numero_chatpe = get_option('chatpe_numero', 'TUNUMERO');
    $imagen_chatpe = get_option('chatpe_imagen', 'URL_DE_LA_IMAGEN');
    ?>
    <style>
        .chatpe-button-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }
    </style>
    <div class="chatpe-button-container">
        <a href="https://chatpe.me/<?php echo esc_attr($numero_chatpe); ?>" target="_blank">
            <img src="<?php echo esc_attr($imagen_chatpe); ?>" alt="ChatPe">
        </a>
    </div>
    <?php
}

// JavaScript para manejar la selección de la imagen
function chatpe_seleccionar_imagen() { ?>
    <script>
        jQuery(document).ready(function($) {
            $('#chatpe_seleccionar_imagen').on('click', function(e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Selecciona una imagen',
                    button: {
                        text: 'Usar esta imagen'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#chatpe_imagen').val(attachment.url);
                    $('#chatpe_imagen_preview').html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto;" />');
                });

                frame.open();
            });
        });
    </script>
<?php }
add_action('wp_footer', 'mostrar_boton_chatpe');
?>
