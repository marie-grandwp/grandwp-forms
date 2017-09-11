<?php
namespace GDForm\Database\Migrations;


class CreateSettingsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormSettings(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Name varchar(50)  DEFAULT NULL,
                Value varchar(50)  DEFAULT NULL,               
                PRIMARY KEY (Id),
                UNIQUE (Name)
            ) ENGINE=InnoDB"
        );
    }

}