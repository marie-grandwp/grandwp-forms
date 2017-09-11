<?php

namespace GDForm\Controllers\Admin;


use GDForm\Helpers\View;

class ReviewNoticeController
{

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'delayNotices' ) , 1);
        add_action( 'admin_notices', array( $this, 'reviewNotice' ) , 1);
    }

    /* ask user for review */
    public function delayNotices()
    {
        if ( isset( $_GET['gdform_delay_notice'] ) ) {

            update_option('gdform_review_notice_delayed',date('Y-m-d H:i:s'));

            $redirectLink = remove_query_arg( array( 'gdform_delay_notice' ) );
            wp_redirect( $redirectLink );
            exit;
        } else if ( isset( $_GET['gdform_ignore_notice'] ) ) {
            update_option('gdform_review_notice_ignore', 1 );
            $redirectLink = remove_query_arg( array( 'gdform_ignore_notice' ) );
            wp_redirect( $redirectLink );
            exit;
        }
    }

    /* ask user for review */
    public function reviewNotice()
    {
        if(isset($_GET['page']) && in_array($_GET['page'],array('gdfrm','gdfrm_submissions','gdfrm_settings','gdfrm_plugins'))) {
            if( !get_option('gdform_review_notice_ignore') && ( !get_option('gdform_review_notice_delayed') || (get_option('gdform_review_notice_delayed') && (strtotime('now') - strtotime(get_option('gdform_review_notice_delayed'))) > 604800)) && ((strtotime('now') - strtotime(get_option('gdform_plugin_installed'))) > 604800) ){
                View::render('admin/review-banner.php');
            }
        }
    }

}