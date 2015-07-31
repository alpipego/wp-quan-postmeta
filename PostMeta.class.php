<?php
    
namespace Quan;

class PostMeta
{
    /**
     * on construction check if acf plugin is activated
     * if not self-deactivate and show the user a message
     */
    function __construct()
    {
        $this->includeFields();
        !is_admin() ? $this->outputMeta() : '';
    }

    function includeFields()
    {
        // require the acf fields
        require 'acf-meta.php';
    }

    /**
     * check if headspace/quan_summary has already been converted
     * converts other fields to description and updates option
     * so this does not run every time (i.e. only once or if forced)
     */
    function convertHeadspace()
    {
        if (!get_option('headspace_converted')) {
            add_action('wp_head', function() {
                $query = new \WP_Query(array(
                    'post_type' => array(
                        'post',
                        'page',
                        'quan_jobs',
                        ),
                    'posts_per_page' => -1,
                    )
                );

                while ($query->have_posts()) {
                    $query->the_post();

                    $description = strlen(get_post_meta(get_the_id(), '_headspace_description', true)) > 1 ? get_post_meta(get_the_id(), '_headspace_description', true) : get_field('quan_excerpt');

                    update_post_meta(get_the_id(), 'quan_meta_description', $description);
                    update_post_meta(get_the_id(), 'quan_meta_title', get_post_meta(get_the_id(), '_headspace_page_title', true));
                }
            
                update_option('headspace_converted', 1);
            }); 
        }  
    }

    function outputMeta()
    {
        add_action('wp_head', function(){
            echo !empty($title = trim(get_post_meta(get_the_id(),'quan_meta_title', true))) ? sprintf('<meta name="title" content="%s">', $title) : sprintf('<meta name="title" content="%s">', get_the_title());
            echo !empty($description = trim(get_post_meta(get_the_id(),'quan_meta_description', true))) ? sprintf('<meta name="description" content="%s">', $description) : '';
        });
    }

    function title()
    {
        return !empty($title = trim(get_post_meta(get_the_id(),'quan_meta_title', true))) ? sprintf('<meta name="title" content="%s">', $title) : sprintf('<meta name="title" content="%s">', get_the_title());
    }
}