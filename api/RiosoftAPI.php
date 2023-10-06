<?php
class RiosoftAPI {
    private $base_url = 'https://apibeta.riosoft.cl/enterprise/v1/';
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function get_access_token() {
        $url = $this->base_url . 'authorization/login/service_clients';
        $response = wp_remote_get($url, array(
            'headers' => array(
                'email' => $this->email,
                'password' => $this->password
            )
        ));
        if (is_wp_error($response)) {
            error_log('Error: ' . $response->get_error_message());
            return false;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if (isset($data['access_token'])) {
            return array(
                'access_token' => $data['access_token'],
                'token_type' => $data['token_type'],
                'expires_in' => $data['expires_in'],
                'issued_at' => $data['issued_at'],
                'client_id' => $data['client_id'],
                'refresh_token' => $data['refresh_token']
            );
        }
        error_log('Error obteniendo el token de acceso de Riosoft API.');
        return false;
    }
}
?>
