<?php
/**
 * Plugin Name:       WooCommerce SII Extension
 * Plugin URI:        https://github.com/NicolasVeas/woocommerce-sii-extension
 * Description:       Extensión de Facturación de SII para WooCommerce.
 * Version:           1.0.0
 * Author:            NicolásVeas
 * Author URI:        https://yourwebsite.com
 * License:           BSD
 * Text Domain:       woocommerce-sii-extension
 * Domain Path:       /languages
 */

// Si este archivo es llamado directamente, aborta.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Incluir los archivos necesarios
require_once plugin_dir_path(__FILE__) . 'db/DatabaseManager.php';
require_once plugin_dir_path(__FILE__) . 'controllers/ConfigController.php';
require_once plugin_dir_path(__FILE__) . 'api/RiosoftAPI.php';

// Instanciar el controlador
$config_controller = new ConfigController();

// Registrar la página de configuración
add_action('admin_menu', array($config_controller, 'register_config_page'));

// Guardar las credenciales
add_action('admin_init', array($config_controller, 'save_credentials'));

// Crear las tablas en la activación del plugin
register_activation_hook(__FILE__, array('DatabaseManager', 'create_tables'));
