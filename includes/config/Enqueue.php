<?php

namespace CrmRoadmap\Config;

class Enqueue {

    private $plugin_name;
    private $version;

    public function __construct() {
        $this->plugin_name = PLUGIN_NAME;
        $this->version = CRMROADMAP_VERSION;
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'custom_css',
            CRMROADMAP_PUBLIC . 'css/public.css',
            array(),
            time()
        );
        // Enqueue Bootstrap CSS
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
            array(),
            '5.0.2',
            'all'
        );
    }

    public function enqueue_scripts() {
        // Enqueue Bootstrap JavaScript
        wp_enqueue_script(
            'bootstrap-bundle',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            '5.0.2',
            true
        );
        wp_enqueue_script('custom_js', CRMROADMAP_PUBLIC .'/assets/js/admin.js', null, time(), true);
        wp_localize_script( 'custom_js', 'wp_roadmap_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'my_ajax_nonce' )
        ) );
    }

    public function localize_scripts(){
        wp_localize_script( 'custom_js', 'wp_roadmap_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'my_ajax_nonce' )
        ) );
    }
}
