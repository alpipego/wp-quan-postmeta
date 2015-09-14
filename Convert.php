<?php

namespace QuanDigital\PostMeta;

class Convert
{
    public function __construct()
    {
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
            
            $this->convertTitle($query->post->ID);
            $this->convertDescription($query->post->ID);
        }

        $this->success;
    }


    public function convertTitle($postId)
    {

        \update_post_meta($postId, 'quan_meta_title', \get_post_meta($postId, '_headspace_page_title', true));
    
    }

    public function convertDescription($postId)
    {
        $description = strlen(\get_post_meta($postId, '_headspace_description', true)) > 1 ? \get_post_meta($postId, '_headspace_description', true) : \get_field('quan_excerpt');
        \update_post_meta(get_the_id(), 'quan_meta_description', $description);

    }

    public function success()
    {
        \update_option('headspace_converted', 1);
    }
}