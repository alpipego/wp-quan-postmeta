<?php

namespace QuanDigital\PostMeta;

class Description
{
    public $description;

    function __construct()
    {
        if (\is_archive() || is_home()) {
            $this->description = $this->getArchive();
        } else if (\is_author()) {
            $this->description = $this->getProfile();
        } else {
            $this->description = $this->getSingle();
        }
    }

    function getSingle()
    {
        return !empty($description = trim(\get_post_meta(\get_the_id(), 'quan_meta_description', true))) ? $description : false;        
    }

    function getProfile()
    {
        $user = \get_user_by('slug', \get_query_var('author_name'));
        return !empty($description = trim(\get_field('description', 'user_' . $user->ID))) ? $description : false;
    }

    function getArchive()
    {
        $page = get_page_by_path($_SERVER['REQUEST_URI']);

        return !empty($description = trim(\get_post_meta($page->ID, 'quan_meta_description', true))) ? $description : false;
    }
}
