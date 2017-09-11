<?php

namespace GDForm\Database\Migrations;


class CreateFormsTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormForms(
				Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				Name text DEFAULT NULL,
				DisplayTitle int(1) UNSIGNED NOT NULL DEFAULT '1',
				ActionOnsubmitId int(11) UNSIGNED NOT NULL DEFAULT '1',
				LabelsPositionId int(11) UNSIGNED NOT NULL DEFAULT '4',
				ThemeId int(5) UNSIGNED NOT NULL DEFAULT '1',
				EmailUsers int(1) UNSIGNED NOT NULL DEFAULT '1',
				EmailAdmin int(1) UNSIGNED NOT NULL DEFAULT '1',
				FromEmail varchar(50) DEFAULT NULL,
				FromName varchar(50) DEFAULT NULL,
				UserSubject varchar(255) DEFAULT 'You Submitted a Form',
				AdminSubject varchar(255) DEFAULT 'A Form Was Submitted on Your Website',
				UserMessage text DEFAULT NULL,
				AdminMessage text DEFAULT NULL,
				AdminEmail varchar(50) DEFAULT NULL,
				SuccessMessage text DEFAULT NULL,
				HideFormOnsubmit int(1) DEFAULT '0',
				RedirectUrl varchar(255) DEFAULT NULL,
				EmailFormatError varchar(100) DEFAULT NULL,
				RequiredEmptyError varchar(100) DEFAULT NULL,
				UploadSizeError varchar(100) DEFAULT NULL,
				UploadFormatError varchar(100) DEFAULT NULL,
				SaveSubmissions int(1) DEFAULT '1',
				Recaptcha varchar(7),
				SubmitNoticeShown int(1) DEFAULT '0',
				IsPreview int(1) DEFAULT 0,
				PRIMARY KEY (Id),
				FOREIGN KEY (ThemeId) REFERENCES " . $wpdb->prefix . "GDFormThemes (Id),
				FOREIGN KEY (LabelsPositionId) REFERENCES " . $wpdb->prefix . "GDFormLabelPositions (Id) ON DELETE CASCADE,
				FOREIGN KEY (ActionOnsubmitId) REFERENCES " . $wpdb->prefix . "GDFormOnsubmitActions (Id) ON DELETE CASCADE
			) ENGINE=InnoDB"
        );

        self::alterTable();

    }


    public static function alterTable()
    {
        global $wpdb;

        $columns = array(
            "IsPreview"=>"int(1) DEFAULT 0",
        );

        foreach ($columns as $column=>$columnType){
            $exists = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_schema = '" . $wpdb->dbname . "' AND table_name = '" . $wpdb->prefix . "GDFormForms' AND column_name = '".$column."'"  );

            if(empty($exists)){
                $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "GDFormForms` ADD {$column} {$columnType}");
            }
        }
    }

}