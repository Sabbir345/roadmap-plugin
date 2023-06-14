<?php
namespace CrmRoadmap\Classes;
//use CrmRoadmap\Classes;

class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
    }

    public function  addMenus()
    {
        $hook = add_menu_page(
            __('CRM Roadmap', 'crm-roadmap'),
            __('CRM Roadmap', 'crm-roadmap'),
            'manage_options',
            'crm_roadmap',
            array($this, 'admin_menu_page'),
            'dashicons-lock',
            10
        );
        add_submenu_page(
            'crm_roadmap',
            'Roadmap',
            'Roadmap',
            'manage_options',
            'crm_roadmap#/roadmap',
            array( $this, 'plugin_index' ),
        );

        add_action('load-' . $hook, array($this, 'init_hooks'));
    }

    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('crm-roadmap-app', CRMROADMAP_PUBLIC .'/css/custom.css', __FILE__ );
        wp_enqueue_script('crm-roadmap-app', CRMROADMAP_PUBLIC .'/assets/js/admin.js', null, time(), true);
        wp_localize_script( 'crm-roadmap-app', 'crm_roadmap_ajax', array(
            'ajaxurl'         => admin_url('admin-ajax.php'),
            'nonce'           => wp_create_nonce('ajax-nonce')
        ));
    }

    public function admin_menu_page()
    {
//        echo '<div id="roadmap-app"></div>';
        echo '<div id="crm-roadmap-app"></div>';
    }
}