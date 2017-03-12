<?php

namespace Alpipego\PostMeta;

use Alpipego\PostMeta\Convert\Converter;
use Alpipego\PostMeta\Convert\Headspace;
use Alpipego\PostMeta\Convert\Version1to2;
use Alpipego\PostMeta\Meta\Description;
use Alpipego\PostMeta\Meta\Languages;
use Alpipego\PostMeta\Meta\Robots;
use Alpipego\PostMeta\Meta\Title;
use Alpipego\WpLib\DIContainer;
use Composer\Autoload\ClassLoader;

/**
 * Plugin Name: Quan Post Meta
 * Plugin URI: https://github.com/quandigital/wp-quan-postmeta
 * Author: Quan Digital GmbH
 * Author URI: http://www.quandigital.com/
 * Description: Adds meta information to posts (requires acf)
 * Version: 2.0.0
 * License: MIT
 */

$loader = new ClassLoader();
// register classes with namespaces
$loader->addPsr4( 'Alpipego\\PostMeta\\', __DIR__ . '/src' );

// activate the autoloader
$loader->register();

$c = new DIContainer();

$c['postmeta'] = function ( $c ) {
	return new Plugin( __FILE__, $c );
};

$c['convert'] = function ( $c ) {
	return new Converter( $c );
};

$c['convert_headspace'] = function () {
	return new Headspace();
};

$c['convert_version1to2'] = function () {
	return new Version1to2();
};

\register_activation_hook( __FILE__, function () use ( $c ) {
	call_user_func( [ $c['convert'], 'convert' ] );
} );

$c['meta_title'] = function () {
	return new Title();
};

$c['meta_description'] = function () {
	return new Description();
};
$c['meta_robots']      = function () {
	return new Robots();
};
$c['meta_languages']   = function () {
	return new Languages();
};

add_action( 'plugins_loaded', function () use ( $c ) {
	$c->run();
} );
