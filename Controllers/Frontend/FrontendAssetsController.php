<?php

namespace GDForm\Controllers\Frontend;

use GDForm\Models\Form;

class FrontendAssetsController
{

    public static function init()
    {
        add_action( 'gdfrmShortcodeScripts', array( __CLASS__, 'addScripts' ) );

        add_action( 'gdfrmShortcodeScripts', array( __CLASS__, 'addStyles' ) );

        add_action( 'wp_head', array( __CLASS__, 'addAjaxUrlJs' ) );

    }

    /**
     * Add Scripts
     *
     */
    public static function addScripts( $FormId ) {

        $Form = new Form(array('Id'=>$FormId));

        wp_enqueue_script( 'jqueryUI',\GDForm()->pluginUrl() . '/assets/js/jquery-ui.min.js');
        wp_enqueue_script( 'jqueryMask',\GDForm()->pluginUrl() . '/assets/js/maskedInputs.js');
        wp_enqueue_script( 'select2', \GDForm()->pluginUrl().'/assets/js/select2.min.js', array( 'jquery','jqueryUI' ), false, true );
        wp_enqueue_script( 'gdfrmFrontJs', \GDForm()->pluginUrl() . '/assets/js/frontend/main.js',
            array(
                'jquery', 'jqueryUI','jqueryMask','select2'
            ),
            false, true
        );

        if($Form->getRecaptcha())
            wp_enqueue_script( 'gdfrm_recaptcha', 	'https://www.google.com/recaptcha/api.js', array( 'jquery' ), '1.0.0', true );

    }


    /**
     * Define the 'ajaxurl' JS variable, used by themes and plugins as an AJAX endpoint.
     *
     */
    public static function addAjaxUrlJs() {
        ?>

        <script
            type="text/javascript">var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', is_ssl() ? 'admin' : 'http' ); ?>';</script>

        <?php
    }

    /**
     * Add Styles
     */
    public static function addStyles( ) {
        wp_enqueue_style( 'jqueryUI', \GDForm()->pluginUrl() . '/assets/css/jquery-ui.min.css');
        wp_enqueue_style( 'flavorsFont', \GDForm()->pluginUrl() . '/assets/css/flavorsFont.css');
        wp_enqueue_style( 'fontAwesome', \GDForm()->pluginUrl() . '/assets/css/font-awesome.min.css' );
        wp_enqueue_style( 'select2', \GDForm()->pluginUrl().'/assets/css/select2.min.css');
        wp_enqueue_style( 'gdfrmFrontCss', \GDForm()->pluginUrl() . '/assets/css/frontend/main.css' ,array('jqueryUI','select2','flavorsFont','fontAwesome'));
    }

}