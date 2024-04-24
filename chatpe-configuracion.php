<?php
// Add configuration page
function chatpe_agregar_pagina_configuracion() {
    add_options_page('Configuración de ChatPe Mensajes', 'ChatPe Mensajes', 'manage_options', 'chatpe-configuracion', 'chatpe_mostrar_pagina_configuracion');
}
add_action('admin_menu', 'chatpe_agregar_pagina_configuracion');

// Show configuration page
function chatpe_mostrar_pagina_configuracion() {
    if (!current_user_can('manage_options')) {
        return;
    }
    wp_enqueue_media();
    ?>
    <div class="wrap">
        <h2>Configuración de ChatPe Mensajes</h2>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('chatpe_configuracion'); ?>
            <?php do_settings_sections('chatpe-configuracion'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register and configure settings fields
function chatpe_registrar_configuracion() {
    register_setting('chatpe_configuracion', 'chatpe_numero');
    register_setting('chatpe_configuracion', 'chatpe_imagen');
    add_settings_section('chatpe_seccion_general', 'Configuración General', 'chatpe_mostrar_seccion_general', 'chatpe-configuracion');
    add_settings_field('chatpe_campo_numero', 'Número de ChatPe', 'chatpe_mostrar_campo_numero', 'chatpe-configuracion', 'chatpe_seccion_general');
    add_settings_field('chatpe_campo_imagen', 'Imagen del botón de ChatPe', 'chatpe_mostrar_campo_imagen', 'chatpe-configuracion', 'chatpe_seccion_general');
}
add_action('admin_init', 'chatpe_registrar_configuracion');

// Show general settings section
function chatpe_mostrar_seccion_general() {
    echo '<p>Ingrese el número de teléfono de ChatPe al que desea que apunte el botón.</p>';
}

// Show phone number field
function chatpe_mostrar_campo_numero() {
    $numero_chatpe = get_option('chatpe_numero');
    ?>
    <input type="text" id="chatpe_numero" name="chatpe_numero" value="<?php echo esc_attr($numero_chatpe); ?>" />
    <?php
}

// Show image upload field
function chatpe_mostrar_campo_imagen() {
    $imagen_chatpe = get_option('chatpe_imagen');
    ?>
    <input type="hidden" name="chatpe_imagen" id="chatpe_imagen" value="<?php echo esc_attr($imagen_chatpe); ?>" />
    <input type="button" value="Seleccionar Imagen" class="button-primary" id="chatpe_seleccionar_imagen" />
    <div id="chatpe_imagen_preview">
        <?php if ($imagen_chatpe) : ?>
            <img src="<?php echo esc_attr($imagen_chatpe); ?>" style="max-width: 100px; height: auto;" />
        <?php endif; ?>
    </div>
    <?php
}

// Validate uploaded image
function chatpe_validar_imagen($input) {
    check_admin_referer('chatpe_configuracion');
    if (!empty($_FILES['chatpe_imagen']['name']) && $_FILES['chatpe_imagen']['error'] == 0) {
        $imagen = wp_handle_upload($_FILES['chatpe_imagen'], array('test_form' => false));
        if (!empty($imagen['url'])) {
            return $imagen['url'];
        } else {
            add_settings_error(
                'chatpe_imagen',
                'imagen_no_valida',
                'Ha ocurrido un error al cargar la imagen. Por favor, inténtalo de nuevo.',
                'error'
            );
            return get_option('chatpe_imagen');
        }
    } elseif (empty($_FILES['chatpe_imagen']['name']) && !empty($_POST['chatpe_imagen_actual'])) {
        return get_option('chatpe_imagen');
    } else {
        return '';
    }
}
?>
