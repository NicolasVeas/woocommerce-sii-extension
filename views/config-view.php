<?php

// Archivo: config-view.php

function render_config_view($credentials) {
    ?>
    <div class="wrap">
        <h1>Configuración de la Extensión SII</h1>
        <form method="post" action="">
            <?php wp_nonce_field('save_sii_credentials', 'sii_credentials_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Correo Electrónico</th>
                    <td><input type="text" name="email" value="<?php echo esc_attr($credentials['email'] ?? ''); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Contraseña</th>
                    <td><input type="password" name="password" value="<?php echo esc_attr($credentials['password'] ?? ''); ?>" /></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar">
            </p>
        </form>
        <?php if (isset($credentials['token']) && !empty($credentials['token'])): ?>
            <p>Estado de la conexión: Conectado</p>
            <p>Token: <?php echo esc_html($credentials['token']); ?></p>
        <?php else: ?>
            <p>Estado de la conexión: No conectado</p>
        <?php endif; ?>


    </div>
    <?php
}
