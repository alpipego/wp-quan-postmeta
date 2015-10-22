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
        });
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
}