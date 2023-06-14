<?php

namespace CrmRoadmap\Classes;

class Shortcode{

    public function __construct() {
        add_shortcode('crm-roadmap', [$this, 'crmUserShortcode']);
    }
    public function crmUserShortcode()
    {
         wp_enqueue_script('frontendJquery', 'https://code.jquery.com/jquery-3.6.4.min.js');
         wp_enqueue_style('frontendStyles', plugins_url('../public/css/frontend.css', __FILE__ ));
         wp_enqueue_script('frontendScripts', CRMROADMAP_PUBLIC .'/assets/js/frontend.js', null, time(), true);
         wp_localize_script( 'frontendScripts', 'crm_roadmap_ajax', [
             'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234,
         ]);

         $cont = '<div id="frontend-crm-roadmap-app"></div>';
         return $cont;
    }
}