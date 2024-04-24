<?php
/*
Plugin Name: ChatPe Mensajes 
Plugin URI: https://github.com/sh4rjf/chatpe
Description: Es una solución que incorpora un sistema de chat en tiempo real en tu sitio web, facilitando la interacción instantánea entre los visitantes.
Version: 1.0
Author: Omar Dolores
Author URI: https://github.com/sh4rjf/chatpe
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// Include other files
include_once( plugin_dir_path( __FILE__ ) . 'chatpe-configuracion.php' );
include_once( plugin_dir_path( __FILE__ ) . 'chatpe-boton.php' );
include_once( plugin_dir_path( __FILE__ ) . 'chatpe-scripts.php' );

// Add button to content
function agregar_boton_chatpe_al_contenido($content) {
    if (is_singular()) {
        $content .= mostrar_boton_chatpe();
    }
    return $content;
}
add_filter('the_content', 'agregar_boton_chatpe_al_contenido');
?>
