<?php

namespace QuanDigital\PostMeta;

use QuanDigital\WpLib\Autoload;

/**
 * Plugin Name: Quan Post Meta
 * Plugin URI: https://github.com/quandigital/wp-quan-postmeta
 * Author: Quan Digital GmbH
 * Author URI: http://www.quandigital.com/
 * Description: Adds meta information to posts (requires acf)
 * Version: 1.1.0
 * License: MIT
 */

new Autoload(__DIR__, __NAMESPACE__);

new Plugin(__FILE__);
