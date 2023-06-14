<?php

namespace CrmRoadmap\Config;

use CrmRoadmap\Database\DatabaseMigrations;

class Activator {
    public static function activate() {
        DatabaseMigrations::run();
        flush_rewrite_rules();
    }
}
