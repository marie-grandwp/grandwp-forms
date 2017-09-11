<?php

namespace GDForm\Database\Migrations;

/**
 * Class CreateCaptchasTable
 * @package GDForm\Database\Migrations
 */
class CreateCaptchasTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormCaptchas(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Field int(11) UNSIGNED DEFAULT NULL,
                Captcha varchar(11),
                Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (Id)
            ) ENGINE=InnoDB"
        );
    }

}