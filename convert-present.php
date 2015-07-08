<?php
    
    add_action('wp_head', function() {
        $query = new WP_Query(array(
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