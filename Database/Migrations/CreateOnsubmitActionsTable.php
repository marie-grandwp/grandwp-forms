<?php

namespace GDForm\Database\Migrations;

use GDForm\Models\OnsubmitAction;

class CreateOnsubmitActionsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormOnsubmitActions(
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

        $rows = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormOnsubmitActions LIMIT 1');

        if(!empty($rows)){
            return;
        }

        $actions = array('Success Message','Redirect','Reset Form');
        foreach ($actions as $action){
            $OnsubmitAction = new OnsubmitAction();

            $OnsubmitAction->setName( __($action, GDFRM_TEXT_DOMAIN ) );

            $OnsubmitAction->save();
        }
    }

}