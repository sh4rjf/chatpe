<?php
// Show ChatPe button
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
        .media-frame.mode-select .media-frame-content,
        .media-modal .media-modal-content,
        .media-modal .media-frame-content {
            margin: 30px;
            max-width: calc(100% - 60px);
        }
    </style>
    <div class="chatpe-button-container">
        <a href="https://chatpe.me/<?php echo esc_attr($numero_chatpe); ?>" target="_blank">
            <img src="<?php echo esc_attr($imagen_chatpe); ?>" alt="ChatPe">
        </a>
    </div>
    <?php
}
?>
