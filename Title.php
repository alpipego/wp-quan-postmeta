<?php

namespace QuanDigital\PostMeta;

class Title
{
    public $title;

    function __construct()
    {
        if (\is_author()) {
            $this->title = $this->getProfile();
        } else if (\is_archive() || is_home()) {
            $this->title = $this->getArchive();
        } else {
            $this->title = $this->getSingle();
        }
    }

    function getSingle()
    {
        return !empty($title = trim(\get_post_meta(\get_the_id(), 'quan_meta_title', true))) ? $title : \get_the_title();
    }

    function getProfile()
    {
        $user = \get_user_by('slug', \get_query_var('author_name'));

        return $user->data->display_name . ' - ' . get_bloginfo('title');
    }

    function getArchive()
    {
        $page = get_page_by_path($_SERVER['REQUEST_URI']);
        if (!is_null($page)) {

            return !empty($title = trim(\get_post_meta($page->ID, 'quan_meta_title', true))) ? $title : '';
        }
    }
}
