<?php

/**
 * Plugin Name: CRM Roadmap
 * Plugin URI:  https://github.com/WPManageNinja/wp-job-board
 * Description: Create Job Posting and Manage Jon Application In WordPress
 * Author: Sabbir Ahmad
 * Author URI:  https://sabbir.dev
 * Version: 1.0.0
 * Text Domain: crm-roadmap
 *
 */

define('PLUGIN_NAME', 'CRM Roadmap');
define('CRMROADMAP_VERSION', '1.0.0');
define('CRMROADMAP_DIR', plugin_dir_path(__FILE__));
define('CRMROADMAP_PLUGIN_URL', trailingslashit(plugins_url('', __FILE__)));
define('CRMROADMAP_ASSETS', CRMROADMAP_PLUGIN_URL . '/assets');
define('CRMROADMAP_PUBLIC', CRMROADMAP_PLUGIN_URL . '/public');

if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
}
class CrmRoadmapHome
{
    public function boot()
    {
        if (is_admin()) {
            $this->adminHooks();
        }
    }

    public function adminHooks()
    {
        (new \CrmRoadmap\Classes\Menu())->register();
        add_action( 'wp_ajax_get_roadmaps', [$this, 'getRoadmaps']);
        add_action( 'wp_ajax_create_crm_roadmap', [$this, 'createRoadmaps']);
    }

    public function getRoadmaps()
    {
        global $wpdb;
        $credentialTableName = 'wp_crm_roadmaps';
        $userTableName = 'wp_users';
        $credentials = $wpdb->get_results ( "SELECT * FROM $credentialTableName ");
        return wp_send_json($credentials);
    }

    public function createRoadmaps ()
    {
        global $wpdb;
        $credentialTableName = 'wp_crm_roadmaps';
        $user = wp_get_current_user();

        $wpdb->insert($credentialTableName, [
            'user_id'    => $user->ID,
            'description'  => $_POST['description'],
            'status'  => $_POST['status'],
            'email'  => $_POST['email'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

add_action('plugins_loaded', function () {
    (new CrmRoadmapHome())->boot();
    (new CrmRoadmap\Config\Enqueue());

    // short codes
    (new CrmRoadmap\Classes\Shortcode());

});

register_activation_hook(__FILE__, function () {
    require_once __DIR__ . '/includes/config/Activator.php';
    $activator = new \CrmRoadmap\Config\Activator();
    $activator->activate();
});
register_deactivation_hook(__FILE__, function () {
    require_once __DIR__ . '/includes/config/Deactivator.php';
    $deactivator = new \CrmRoadmap\Config\Deactivator();
    $deactivator->deactivate();
});