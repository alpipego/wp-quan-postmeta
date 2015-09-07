<?php

namespace QuanDigital\PostMeta;

/**
 * Plugin Name: Quan Post Meta
 * Plugin URI: http://www.quandigital.com/
 * Description: Adds meta information to posts (with the help of acf)
 * Version: 1.0.0
 * License: MIT
 */

defined('ABSPATH') or die();
include ABSPATH . '../../vendor/autoload.php';

use QuanDigital\WpLib\Autoload;

new Autoload(__DIR__, __NAMESPACE__);

// create the plugin, pass the importer as object
new PostMetaPlugin(__FILE__, $import);
    