<?php

namespace GDForm\Database;

class Uninstall
{

    public static function init()
    {
        if (\GDForm()->Settings->get('RemoveTablesUninstall')) {
            self::run();
        }
    }

    private function run()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormFieldOptions`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormAddressFieldOptions`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormSubmissionFields`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormSubmissions`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormFields`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormForms`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormThemes`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormFieldTypes`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormOnsubmitActions`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormLabelPositions`");
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."GDFormSettings`");
    }

}