<?php

namespace GDForm\Database\Migrations;


class CreateSubmissionFieldsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormSubmissionFields(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Submission int(11) UNSIGNED DEFAULT NULL,
                Field int(11) UNSIGNED NOT NULL,
                Value text DEFAULT NULL,
                PRIMARY KEY (Id),
                FOREIGN KEY (Field) REFERENCES " . $wpdb->prefix . "GDFormFields (Id) ON DELETE CASCADE,
                FOREIGN KEY (Submission) REFERENCES " . $wpdb->prefix . "GDFormSubmissions (Id) ON DELETE CASCADE
            ) ENGINE=InnoDB"
        );
    }

}