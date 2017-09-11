<?php

namespace GDForm\Database\Migrations;

use GDForm\Models\FieldType;

class CreateFieldTypesTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormFieldTypes(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Name text DEFAULT NULL,
                IsFree int(1) DEFAULT 1,
                PRIMARY KEY (Id)
            ) ENGINE=InnoDB"
        );

        self::insertDefaults();
    }

    private static function insertDefaults()
    {
        global $wpdb;

        $rows = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormFieldTypes LIMIT 1');

        if(!empty($rows)){
            return;
        }

        $defaultTypes=array(
            array('name'=>'text','free'=>'1'),
            array('name'=>'email','free'=>'1'),
            array('name'=>'number','free'=>'1'),
            array('name'=>'textarea','free'=>'1'),
            array('name'=>'radio','free'=>'1'),
            array('name'=>'checkbox','free'=>'1'),
            array('name'=>'selectbox','free'=>'1'),
            array('name'=>'date','free'=>'1'),
            array('name'=>'recaptcha','free'=>'1'),
            array('name'=>'map','free'=>'0'),
            array('name'=>'captcha','free'=>'1'),
            array('name'=>'imageselect','free'=>'0'),
            array('name'=>'html','free'=>'1'),
            array('name'=>'password','free'=>'0'),
            array('name'=>'phone','free'=>'1'),
            array('name'=>'address','free'=>'0'),
            array('name'=>'upload','free'=>'1'),
            array('name'=>'submit','free'=>'1'),
        );

        foreach ($defaultTypes as $defaultType){
            $field_type = new FieldType();

            $field_type->setName( __( $defaultType['name'], GDFRM_TEXT_DOMAIN ) )
                       ->setIsFree($defaultType['free']);

            $field_type->save();
        }

    }

}