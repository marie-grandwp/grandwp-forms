<?php

namespace GDForm\Database\Migrations;


class CreateFieldOptionsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormFieldOptions(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Name varchar(255) DEFAULT NULL,
                Value varchar(255  ) DEFAULT NULL,
                Field int(11) UNSIGNED DEFAULT NULL,
                Checked int(1) DEFAULT '0',
                Ordering int(3) DEFAULT '0',
                Image varchar(255),
                PRIMARY KEY (Id),
				FOREIGN KEY (Field) REFERENCES " . $wpdb->prefix . "GDFormFields (Id) ON DELETE CASCADE
            ) ENGINE=InnoDB"
        );
    }

}