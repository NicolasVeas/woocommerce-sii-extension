<?php
class ConfigModel {

    public function get_credentials() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dte_credentials';
        $query = "SELECT * FROM $table_name LIMIT 1";
        $credentials = $wpdb->get_row($query, ARRAY_A);
        return $credentials;
    }

    public function save_credentials($credentials) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dte_credentials';
        $wpdb->replace(
            $table_name,
            ['email' => $credentials['email'], 'password' => $credentials['password']],
            ['%s', '%s']
        );
    }

    public function save_access_token($data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dte_credentials';
        $existing_entry = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
        if ($existing_entry) {
            $wpdb->update(
                $table_name,
                [
                    'token' => $data['access_token'],
                    'token_type' => $data['token_type'],
                    'expires_in' => $data['expires_in'],
                    'issued_at' => $data['issued_at'],
                    'client_id' => $data['client_id'],
                    'refresh_token' => $data['refresh_token'],
                    'updated_at' => current_time('mysql')
                ],
                ['id' => 1],
                ['%s', '%s', '%d', '%d', '%s', '%s', '%s'],
                ['%d']
            );
        } else {
            $wpdb->insert(
                $table_name,
                [
                    'email' => $data['client_id'],
                    'token' => $data['access_token'],
                    'token_type' => $data['token_type'],
                    'expires_in' => $data['expires_in'],
                    'issued_at' => $data['issued_at'],
                    'client_id' => $data['client_id'],
                    'refresh_token' => $data['refresh_token'],
                    'created_at' => current_time('mysql'),
                    'updated_at' => current_time('mysql')
                ],
                ['%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s']
            );
        }
    }
}
?>
