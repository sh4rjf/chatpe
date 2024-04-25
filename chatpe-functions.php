<?php
// Función para agregar el botón de ChatPe en el contenido del sitio
// Función para agregar el botón de ChatPe en el contenido del sitio
function agregar_boton_chatpe_al_contenido($content) {
    // Verificar si estamos en una página individual y si el contenido no está vacío
    if (is_singular() && !empty($content)) {
        // Agregar el botón de ChatPe después del primer párrafo del contenido
        $content = insertar_boton_chatpe_despues_del_primer_parrafo($content);
    }
    return $content;
}

// Función para insertar el botón de ChatPe después del primer párrafo del contenido
function insertar_boton_chatpe_despues_del_primer_parrafo($content) {
    // Definir el marcador de posición para buscar el primer párrafo
    $primer_parrafo = '<p>';
    
    // Encontrar la posición del primer párrafo en el contenido
    $posicion_primer_parrafo = strpos($content, $primer_parrafo);
    
    // Verificar si se encontró el primer párrafo
    if ($posicion_primer_parrafo !== false) {
        // Separar el contenido en dos partes: antes y después del primer párrafo
        $parte_anterior = substr($content, 0, $posicion_primer_parrafo + strlen($primer_parrafo));
        $parte_posterior = substr($content, $posicion_primer_parrafo + strlen($primer_parrafo));
        
        // Agregar el botón de ChatPe después del primer párrafo
        $content = $parte_anterior . mostrar_boton_chatpe() . $parte_posterior;
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

