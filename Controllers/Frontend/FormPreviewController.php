<?php
namespace GDForm\Controllers\Frontend;

use GDForm\Models\Form;

class FormPreviewController
{
    /**
     * Form ID
     *
     * @var int
     */
    private $Form;

    /***
     * @param
     *
     */
    public function __construct( )
    {
        if ( ! isset( $_GET['gdfrm_preview'] ) ) return;

        $this->Form = intval($_GET['gdfrm_preview']);

        add_filter('the_title', array( $this, 'theTitle' ) );
        add_filter('the_content', array( $this, 'theContent' ), 9001 );
        add_filter('template_include', array( $this, 'templateInclude' ) );
        add_action( 'pre_get_posts', array( $this, 'preGetPosts' ) );
    }
    /**
     * @return string
     */
    public function theTitle( $title )
    {
        if( ! in_the_loop() ) return $title;

        $form = new Form( array('Id'=>$this->Form) );
        $title = $form->getName();

        return $title . " " . __( 'Form Preview', GDFRM_TEXT_DOMAIN);
    }

    /**
     * @return string
     */
    public function theContent()
    {
        if ( ! is_user_logged_in() ) return __( 'Log In first in order to preview the form.', GDFRM_TEXT_DOMAIN );

        return do_shortcode( "[gdfrm_form id='{$this->Form}']" );
    }


    public static function previewUrl($form , $return_html = true ) {

        if($return_html){
            $html = '<a target="_blank" class="gdfrm-preview" href="' . home_url() . '/?gdfrm_preview=' . $form . '">' . __( 'Preview Form', GDFRM_TEXT_DOMAIN ) . '</a>';

            return $html;
        } else {
            return  home_url() . '/?gdfrm_preview=' . $form ;

        }

    }


    public static function templateInclude()
    {
        return locate_template( array( 'page.php','single.php','index.php' ) );
    }


    public static function preGetPosts( $query )
    {
        $query->set( 'posts_per_page', 1 );
    }
}