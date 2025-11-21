<?php
/**
 * Plugin Name: Divi Custom Menu Module
 * Plugin URI: https://example.com
 * Description: Aggiunge un modulo Divi per visualizzare menu WordPress in orientamento orizzontale o verticale
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Carica il modulo solo se Divi è attivo
add_action('divi_extensions_init', 'initialize_divi_menu_module');

function initialize_divi_menu_module() {
    require_once plugin_dir_path(__FILE__) . 'includes/DiviMenuModule.php';
}

// Registra gli stili e script
add_action('wp_enqueue_scripts', 'divi_menu_module_scripts');

function divi_menu_module_scripts() {
    wp_enqueue_style(
        'divi-menu-module-style',
        plugin_dir_url(__FILE__) . 'css/style.css',
        array(),
        '1.0.0'
    );
}
