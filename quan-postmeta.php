<?php
/**
 * Plugin Name: Quan Post Meta
 * Plugin URI: http://www.quandigital.com/
 * Description: Adds meta information to posts (with the help of acf)
 * Version: 1
 * Author: alpipego
 * Author URI: http://alpipego.com/
 */
 
// check if headspace/quan_summary has already been converted
if (!get_option('headspace_converted')) {
    include(__DIR__ . '/convert-present.php'); 
}  

add_action('wp_head', function(){
    echo !empty($title = trim(get_post_meta(get_the_id(),'quan_meta_title', true))) ? sprintf('<meta name="title" content="%s">', $title) : sprintf('<meta name="title" content="%s">', get_the_title());
    echo !empty($description = trim(get_post_meta(get_the_id(),'quan_meta_description', true))) ? sprintf('<meta name="description" content="%s">', $description) : '';
});