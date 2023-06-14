<?php

namespace CrmRoadmap\Database\Migrations;

class RoadmapsMigration {
    public static function migrate() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'crm_roadmaps';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			user_id int(11) NOT NULL,
            email varchar(255) NOT NULL,
            description text NOT NULL,
            status tinyint(1) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}