<?php

namespace CrmRoadmap\config;

class Deactivator {

    public static function deactivate() {
        global $wpdb;

        $table_names = [
            $wpdb->prefix . 'crm_roadmaps',
        ];

        foreach ($table_names as $table_name) {
            $sql = "DROP TABLE IF EXISTS $table_name;";
            $wpdb->query($sql);
        }
        flush_rewrite_rules();
    }

}
