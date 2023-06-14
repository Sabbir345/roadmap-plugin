<?php

namespace CrmRoadmap\Database;

use CrmRoadmap\Database\Migrations\RoadmapsMigration;

class DatabaseMigrations {
    public static function run() {
        RoadmapsMigration::migrate();
    }
}
