<?php

namespace QuanDigital\PostMeta;

use QuanDigital\WpLib\Boilerplate;

class Plugin extends Boilerplate
{
    public function __construct($file)
    {
        parent::__construct($file, [$this, 'convertHeadspace']);

        if (!\is_admin()) {
            $this->outputMeta();
        }
    }

    public function convertHeadspace()
    {
        new Convert();
    }

    function outputMeta()
    {
        add_action('wp_head', function() {
            echo sprintf('<title>%s</title>', $this->getTitle());

            if ($description = $this->getDescription()) {
                echo sprintf('<meta name="Description" content="%s">', $description);
            }

            if ($robots = $this->getRobots()) {
                echo sprintf('<meta name="robots" content="%s">', $robots);
            }
            $this->getAlternateLanguages();
        });

        $this->getLanguage();
    }

    public function addAcfJsonLoadPoint($paths) {
        $paths[] = __DIR__ . '/acf-json';

        return $paths;
    }

    function getTitle()
    {
        return (new Title())->title;
    }

    function getDescription()
    {
        return (new Description())->description;
    }

    function getRobots()
    {
        if (!is_author()) {
            $robots = \get_post_meta(\get_the_id(),'quan_meta_robots', true);

            if (!empty($robots)) {

                return implode(',', $robots);
            }
        }

        return false;
    }

    private function getLanguage()
    {
        add_filter('language_attributes', function($output, $doctype) {
            $lang = explode('_', get_option('WPLANG'));
            $lang = !empty($postLang = trim(\get_post_meta(\get_the_id(), 'quan_meta_language', true))) ? $postLang : $lang[0];

            $output = 'lang="' . $lang . '"';

            if ($doctype === 'xhtml') {
                $output .= ' xml:lang="' . $lang . '"';
            }

            return $output;
        }, 20, 2);
    }

    private function getAlternateLanguages()
    {
        if (have_rows('quan_meta_hreflang')) {
            while (have_rows('quan_meta_hreflang')) {
                the_row();

                echo sprintf('<link rel="alternate" href="%s" hreflang="%s" />', get_sub_field('quan_meta_hreflang_url'), get_sub_field('quan_meta_hreflang_code'));
            }
        }
    }

}
