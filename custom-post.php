<?php

/**
 * Plugin Name: Custom-Archive-with-Multiple-loop
 * Description: Custom post type with Custom Archive Page design.
 * Author: Md Shakibur Rahman
 * Author URI: https://github.com/mdshakiburrahman6
 * Version: 1.0.0 
 */

if(!defined('ABSPATH')) exit;

// Constants
define('CP_PATH', plugin_dir_path( __FILE__ ));
define('CP_URL', plugin_dir_url( __FILE__ ));

// Includes
require_once CP_PATH . 'includes/cpt-portfolio.php';
require_once CP_PATH . 'includes/taxonomy-portfolio.php';
require_once CP_PATH . 'includes/taxonomy-image.php';

// Frontend CSS (optional)
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'custom-post-frontend',
        CP_URL . 'assets/css/frontend.css',
        [],
        '1.0.0'
    );
});