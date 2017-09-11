<?php

namespace GDForm\Database\Migrations;

use GDForm\Models\LabelPosition;

class CreateLabelPositionsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormLabelPositions(
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

        $rows = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormLabelPositions LIMIT 1');

        if(!empty($rows)){
            return;
        }


        $defaultPositions=array('default','left','right','above','hidden');

        foreach ($defaultPositions as $defaultPosition) {

            $label_position = new LabelPosition();

            $label_position->setName(__($defaultPosition, GDFRM_TEXT_DOMAIN));

            $label_position->save();
        }
    }

}