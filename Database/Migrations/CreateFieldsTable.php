<?php

namespace GDForm\Database\Migrations;


class CreateFieldsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormFields(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Form int(11) UNSIGNED DEFAULT NULL,
                Label varchar(100) DEFAULT NULL,
                LabelPosition int(11) UNSIGNED NOT NULL DEFAULT '1',
                Required int(1) DEFAULT '0',
                Disabled int(1) DEFAULT '0',
                Class varchar(30) DEFAULT NULL,
                ContainerClass varchar(30) DEFAULT NULL,
                HelperText text DEFAULT NULL,
                TypeId int(11) UNSIGNED DEFAULT '1',
                DefaultValue text,
                Placeholder varchar(255) DEFAULT NULL,
                Ordering int(3) DEFAULT '0',
                Resizable int(1) DEFAULT '0',
                LimitNumber int(10) DEFAULT '0',
                LimitType varchar(4) DEFAULT 'char',
                LimitText varchar(100),
                Minimum float(12) DEFAULT '0',
                Maximum float(12) DEFAULT '10000',
                NumberType varchar(5) DEFAULT 'int',
                OptionType varchar(12) DEFAULT NULL,
                MapCenter varchar(100) DEFAULT '{lat:48.2222,lng:15.2222}',
                Draggable int(1) DEFAULT 1,
                RecaptchaType varchar(8) DEFAULT NULL,
                RecaptchaStyle varchar(5) DEFAULT NULL,
                MaskOn int(1) DEFAULT NULL,
                MaskPattern varchar(100),
                FileTypes varchar(255) DEFAULT NULL,
                UploadSize int(4) DEFAULT 2,
                MultipleUpload int(1),
                MinDate varchar(40) DEFAULT NULL,
                MaxDate varchar(40) DEFAULT NULL,
                DateFormat varchar(15) DEFAULT 'dd/mm/yy',
                Height int(4) DEFAULT NULL,
                LimitSelected int(4),
                SearchOn int(1) DEFAULT '1',
                PasswordViewToggle int(1) DEFAULT '0',
                PRIMARY KEY (Id),
                FOREIGN KEY (Form) REFERENCES " . $wpdb->prefix . "GDFormForms (Id) ON DELETE CASCADE,
                FOREIGN KEY (LabelPosition) REFERENCES " . $wpdb->prefix . "GDFormLabelPositions (Id) ON DELETE CASCADE,
                FOREIGN KEY (TypeId) REFERENCES " . $wpdb->prefix . "GDFormFieldTypes (Id) ON DELETE CASCADE
            ) ENGINE=InnoDB"
        );
    }

}