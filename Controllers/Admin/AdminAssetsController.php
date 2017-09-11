<?php

namespace GDForm\Controllers\Admin;


class AdminAssetsController
{
    public static function init() {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'adminStyles' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'adminScripts' ) );
    }

    /**
     * @param $hook
     */
    public static function adminStyles( $hook ){

        if( $hook === \GDForm()->Admin->Pages['main_page'] || $hook === \GDForm()->Admin->Pages['settings'] || $hook === \GDForm()->Admin->Pages['submissions'] || $hook === \GDForm()->Admin->Pages['featuredplugins'] || $hook === \GDForm()->Admin->Pages['themes']  ){

            wp_enqueue_style( 'jqueryUI', \GDForm()->pluginUrl() . '/assets/css/jquery-ui.min.css' );

            wp_enqueue_style( 'fontAwesome', \GDForm()->pluginUrl() . '/assets/css/font-awesome.min.css',false );

            wp_enqueue_style( 'gdfrmSelect2',\GDForm()->pluginUrl().'/assets/css/select2.min.css', false);

            wp_enqueue_style( 'gdfrmAdminStyles', \GDForm()->pluginUrl().'/assets/css/admin/main.css' );

            wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic' );

        }

        if($hook === \GDForm()->Admin->Pages['settings']){

            wp_enqueue_style( 'gdfrmSettings', \GDForm()->pluginUrl().'/assets/css/admin/settings.css' );
        }

        if($hook === \GDForm()->Admin->Pages['submissions']){
            wp_enqueue_style( 'gdfrmSubmissions', \GDForm()->pluginUrl().'/assets/css/admin/proPages.css' );
        }


        if(isset($_GET['task']) && $_GET['task']=='edit_form_settings'){

        }

        if($hook === \GDForm()->Admin->Pages['featuredplugins']){
            wp_enqueue_style( 'gdfrmSubmissions', \GDForm()->pluginUrl().'/assets/css/admin/featuredplugins.css' );
        }

        if($hook === \GDForm()->Admin->Pages['themes']){
            wp_enqueue_style( 'gdfrmSubmissions', \GDForm()->pluginUrl().'/assets/css/admin/proPages.css' );
        }

        //if($hook === 'plugins.php'){
        wp_enqueue_style( 'gdfrmAdminNotices', \GDForm()->pluginUrl().'/assets/css/admin/AdminNotices.css' );
        //}

    }

    /**
     * @param $hook
     */
    public static function adminScripts( $hook ){
        if( $hook === \GDForm()->Admin->Pages['main_page']  ){

            wp_enqueue_media();

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script('jqueryUI',\GDForm()->pluginUrl().'/assets/js/jquery-ui.min.js');

            if( isset($_GET['task']) && $_GET['task'] == 'edit_form' ){
                wp_enqueue_script( 'gdfrmAdminSelect2', \GDForm()->pluginUrl().'/assets/js/select2.min.js', array( 'jquery','jqueryUI' ), false, true );

                wp_enqueue_script( 'gdfrmAdminFormSave', \GDForm()->pluginUrl().'/assets/js/admin/form-save.js', array( 'jquery','jqueryUI' ), false, true );

            }


            if(isset($_GET['task']) && $_GET['task']=='edit_form_settings'){
                wp_enqueue_script( 'gdfrmFormSettings', \GDForm()->pluginUrl().'/assets/js/admin/form-settings.js', array( 'jquery' ), false, true );

            }

            wp_enqueue_script( 'gdfrmAdminJs', \GDForm()->pluginUrl().'/assets/js/admin/main.js', array( 'jquery' ,'jqueryUI'), false, true );
        }

        if( in_array( $hook, array('post.php', 'post-new.php') ) ){
            wp_enqueue_script( "gdfrmInlinePopup", \GDForm()->pluginUrl()."/assets/js/admin/inline-popup.js", array( 'jquery' ), false, true );
        }

        if($hook === \GDForm()->Admin->Pages['settings']){
            wp_enqueue_script( 'gdfrmSettings', \GDForm()->pluginUrl().'/assets/js/admin/settings.js',array( 'jquery' ), false, true );
        }

        if($hook === \GDForm()->Admin->Pages['submissions']){
            wp_enqueue_script( 'gdfrmSubmissions', \GDForm()->pluginUrl().'/assets/js/admin/submissions.js',array( 'jquery' ), false, true );
        }

        self::localizeScripts();

    }

    public static function localizeScripts(){

        wp_localize_script( 'gdfrmAdminFormSave', 'formSave',array(
            'nonce'=>wp_create_nonce( 'gdfrm_save_form' ),
        ) );

        wp_localize_script( 'gdfrmInlinePopup', 'inlinePopup',array(
            'nonce'=>wp_create_nonce( 'gdfrm_save_shortcode_options' ),
        ) );

        wp_localize_script( 'gdfrmAdminFormSave', 'field',array(
            'removeNonce'=>wp_create_nonce( 'gdfrm_remove_field' ),
            'duplicateNonce'=>wp_create_nonce( 'gdfrm_duplicate_field' ),
            'saveNonce'=>wp_create_nonce( 'gdfrm_save_field' ),
            'addOptionNonce'=>wp_create_nonce( 'gdfrm_add_field_option' ),
            'removeOptionNonce'=>wp_create_nonce( 'gdfrm_remove_field_option' ),
            'importOptionsNonce'=>wp_create_nonce( 'gdfrm_import_options' ),
        ) );

        wp_localize_script( 'gdfrmFormSettings', 'gdform',array(
            'saveSettingsNonce'=>wp_create_nonce( 'gdfrm_save_form_settings' ),
        ) );

        wp_localize_script( 'gdfrmSettings', 'settingsSave',array(
            'nonce'=>wp_create_nonce( 'gdfrm_save_settings' ),
        ) );

        wp_localize_script( 'gdfrmSubmissions', 'submission',array(
            'removeNonce'=>wp_create_nonce( 'gdfrm_remove_submission' ),
            'readNonce'=>wp_create_nonce( 'gdfrm_read_submission' ),
        ) );

        wp_localize_script( 'gdfrmAdminJs', 'form',array(
            'removeNonce'=>wp_create_nonce( 'gdfrm_remove_form' ),
        ) );




    }
}