<?php
// Handle image selection
function chatpe_seleccionar_imagen() { ?>
    <script>
        jQuery(document).ready(function($) {
            $('#chatpe_seleccionar_imagen').on('click', function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Selecciona una imagen',
                    button: { text: 'Usar esta imagen' },
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
add_action('admin_footer', 'chatpe_seleccionar_imagen');
?>
