<?php

namespace GDForm\Database\Migrations;


use GDForm\Helpers\Countries;

class CreateAddressFieldOptionsTable
{

    public static function run()
    {
        global $wpdb;


        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormAddressFieldOptions(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Field int(11) UNSIGNED NOT NULL,
                ShowCountry int(1) DEFAULT 1,
                PlaceholderCountry int(11) UNSIGNED DEFAULT NULL,
                Countries text,
                ShowState int(1) DEFAULT 1,
                ShowCity int(1) DEFAULT 1,
                ShowAddress int(1) DEFAULT 1,
                ShowZip int(1) DEFAULT 1,
                SearchOn int(1) DEFAULT 1,
                                
                PRIMARY KEY (Id),
				FOREIGN KEY (Field) REFERENCES " . $wpdb->prefix . "GDFormFields (Id) ON DELETE CASCADE
            ) ENGINE=InnoDB "
        );
    }

}