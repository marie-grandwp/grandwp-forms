<?php

namespace GDForm\Database\Migrations;

use GDForm\Models\Theme;

class CreateThemesTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormThemes(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Name text DEFAULT NULL,
                PRIMARY KEY (Id)
            ) ENGINE=InnoDB"
        );

        self::insertDefaults();
    }

    private static function insertDefaults()
    {
        global $wpdb;

        $rows = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormThemes LIMIT 1');

        if(!empty($rows)){
            return;
        }

        $theme = new Theme();

        $theme->setName( __( 'Default', GDFRM_TEXT_DOMAIN ) );

        $theme->save();
    }

}