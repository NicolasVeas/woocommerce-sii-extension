<?php

class DatabaseManager {

    public static function create_tables() {
        global $wpdb;  // Objeto global de WordPress para interactuar con la base de datos

        $charset_collate = $wpdb->get_charset_collate();  // Obtener el conjunto de caracteres y la collation de la BD de WordPress

        // Definición de las tablas en SQL
        $sql = "
        CREATE TABLE {$wpdb->prefix}dte_credentials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            token_type VARCHAR(255),
            expires_in VARCHAR(255),
            issued_at VARCHAR(255),
            client_id VARCHAR(255),
            refresh_token VARCHAR(255),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) $charset_collate;
        CREATE TABLE {$wpdb->prefix}dte_emisores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            rut VARCHAR(12) NOT NULL,
            nombre VARCHAR(255) NOT NULL,
            direccion VARCHAR(255) NOT NULL,
            ciudad VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) $charset_collate;
        CREATE TABLE {$wpdb->prefix}dte_receptores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            rut VARCHAR(12) NOT NULL,
            nombre VARCHAR(255) NOT NULL,
            direccion VARCHAR(255) NOT NULL,
            ciudad VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP        
        ) $charset_collate;
        CREATE TABLE {$wpdb->prefix}dtes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            document_id INT NOT NULL,
            document_type INT NOT NULL,
            document_number INT NOT NULL,
            status VARCHAR(50) NOT NULL,
            document_date DATETIME NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP     
        ) $charset_collate;
        CREATE TABLE {$wpdb->prefix}dtdte_envios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            folio INT NOT NULL,
            sending_status VARCHAR(50) NOT NULL,
            effective_status VARCHAR(50) NOT NULL,
            effective_date DATETIME NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) $charset_collate;
    ";

        // Incluir el archivo upgrade.php para usar la función dbDelta
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        // Ejecutar la definición de las tablas
        dbDelta($sql);
    }
}
