<?php

namespace QuanDigital\PostMeta;

class Convert
{
    public function __construct()
    {
        $query = new \WP_Query([
            'post_type' => 'any',
            'posts_per_page' => -1,
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                
                $this->convertTitle($query->post->ID);
                $this->convertDescription($query->post->ID);
                $this->convertRobots($query->post->ID);
            }
        }
    }


    public function convertTitle($postId)
    {
        if (empty(trim(\get_post_meta($postId, 'quan_meta_title', true)))) {
            \update_post_meta($postId, 'quan_meta_title', \get_post_meta($postId, '_headspace_page_title', true));
        }
    }

    public function convertDescription($postId)
    {
        if (empty(trim(\get_post_meta($postId, 'quan_meta_description', true)))) {
            $description = strlen(\get_post_meta($postId, '_headspace_description', true)) > 1 ? \get_post_meta($postId, '_headspace_description', true) : \get_field('quan_excerpt');
            \update_post_meta($postId, 'quan_meta_description', $description);
        }
    }

    public function convertRobots($postId)
    {
        if (\get_post_meta($postId, 'quan_meta_robots', true)) {
            $robots = [];
            foreach (['nofollow', 'noarchive', 'noindex',] as $botDirective) {
                $hsDirective = \get_post_meta($postId, '_headspace_' . $botDirective, true);
                if ($hsDirective === 'robots') {
                    $robots[] = $botDirective;
                }
            }
            \update_post_meta($postId, 'quan_meta_robots', $robots);
            unset($robots);
        }   
    }
}