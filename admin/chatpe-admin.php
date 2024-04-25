<?php
// Función para agregar la página de configuración al panel de administración
function chatpe_agregar_pagina_configuracion() {
    add_menu_page(
        'Configuración de ChatPe Mensajes', // Título de la página
        'ChatPe Mensajes', // Título del menú
        'manage_options', // Capacidad requerida para acceder
        'chatpe-configuracion', // Slug de la página
        'chatpe_mostrar_pagina_configuracion', // Callback de la página
        'dashicons-format-status', // Icono para la página
        20 // Posición en el menú
    );
}
add_action('admin_menu', 'chatpe_agregar_pagina_configuracion');

// Función para mostrar la página de configuración
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

// Función para registrar y configurar los campos
function chatpe_registrar_configuracion() {
    register_setting('chatpe_configuracion', 'chatpe_numero', 'chatpe_validar_numero');
    register_setting('chatpe_configuracion', 'chatpe_imagen');
    add_settings_section('chatpe_seccion_general', 'Configuración General', 'chatpe_mostrar_seccion_general', 'chatpe-configuracion');
    add_settings_field('chatpe_campo_numero', 'Número de ChatPe', 'chatpe_mostrar_campo_numero', 'chatpe-configuracion', 'chatpe_seccion_general');
    add_settings_field('chatpe_campo_imagen', 'Imagen del botón de ChatPe', 'chatpe_mostrar_campo_imagen', 'chatpe-configuracion', 'chatpe_seccion_general');
}
add_action('admin_init', 'chatpe_registrar_configuracion');

// Función para mostrar la sección de configuración general
function chatpe_mostrar_seccion_general() {
    echo '<p>Ingrese el número de teléfono de ChatPe al que desea que apunte el botón.</p>';
}

// Función para mostrar el campo de número de teléfono
function chatpe_mostrar_campo_numero() {
    $numero_chatpe = get_option('chatpe_numero');
    ?>
    <input type="text" id="chatpe_numero" name="chatpe_numero" value="<?php echo esc_attr($numero_chatpe); ?>" />
    <?php
}

// Función para mostrar el campo de carga de imagen
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

// Función para validar el número de ChatPe
function chatpe_validar_numero($input) {
    $numero_chatpe = trim($input);
    if (empty($numero_chatpe)) {
        add_settings_error(
            'chatpe_numero',
            'numero_invalido',
            'Por favor, ingrese un número de ChatPe válido.',
            'error'
        );
        return get_option('chatpe_numero');
    }
    return $numero_chatpe;
}
?>
