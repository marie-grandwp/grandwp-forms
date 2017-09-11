<?php
namespace GDForm\Database\Migrations;

class CreateSubmissionsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormSubmissions(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                Form int(11) UNSIGNED DEFAULT NULL,
                IpAddress varchar(39),
                Viewed int(1) DEFAULT '0',
                Spam int(1) DEFAULT '0',
                PRIMARY KEY (Id),
                FOREIGN KEY (Form) REFERENCES " . $wpdb->prefix . "GDFormForms (Id) ON DELETE CASCADE
            ) ENGINE=InnoDB"
        );

    }

}