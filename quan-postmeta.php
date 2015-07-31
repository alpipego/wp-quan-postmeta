<?php
/**
 * Plugin Name: Quan Post Meta
 * Plugin URI: http://www.quandigital.com/
 * Description: Adds meta information to posts (with the help of acf)
 * Version: 1.0.0
 * License: MIT
 */

    defined( 'ABSPATH' ) or die();

    if (!class_exists('acf')) {
        add_action('admin_init', function() {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            add_action('admin_notices', function() {
                echo '<div class="error"><p>Please activate <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields</a> first.</p></div>';
            });
        });
    } else {
        include 'PostMeta.class.php';
        new \Quan\PostMeta();
    }
    