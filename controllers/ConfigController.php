<?php
require_once plugin_dir_path(__FILE__) . '../api/RiosoftAPI.php';
require_once plugin_dir_path(__FILE__) . '../models/ConfigModel.php';
require_once plugin_dir_path(__FILE__) . '../views/config-view.php';

class ConfigController {
    private $model;

    public function __construct() {
        $this->model = new ConfigModel();
    }

    public function register_config_page() {
        add_menu_page(
            'Configuración de la Extensión SII',
            'Configuración SII',
            'manage_options',
            'sii-config',
            array($this, 'render_config_page')
        );
    }

    public function render_config_page() {
        $credentials = $this->model->get_credentials();
        render_config_view($credentials);
    }

    public function save_credentials() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('save_sii_credentials', 'sii_credentials_nonce')) {
            $credentials = array(
                'email' => sanitize_text_field($_POST['email']),
                'password' => sanitize_text_field($_POST['password']),
            );
            $this->model->save_credentials($credentials);
            $this->get_access_token();
        }
    }

    public function get_access_token() {
        $credentials = $this->model->get_credentials();
        if ($credentials) {
            $email = $credentials['email'];
            $password = $credentials['password'];
            $api = new RiosoftAPI($email, $password);
            try {
                $response = $api->get_access_token();
                if ($response && isset($response['access_token'])) {
                    $this->model->save_access_token($response);
                } else {
                    error_log('Error obteniendo el token de acceso de Riosoft API. Respuesta: ' . print_r($response, true));
                }
            } catch (Exception $e) {
                error_log('Excepción en Riosoft API: ' . $e->getMessage());
            }
        } else {
            error_log('No hay credenciales almacenadas para Riosoft API.');
        }
    }
}
?>
