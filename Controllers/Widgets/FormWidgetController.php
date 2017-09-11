<?php

namespace GDForm\Controllers\Widgets;

use GDForm\Helpers\View;

class FormWidgetController extends \WP_Widget  {
    /**
     * Widget constructor.
     */
    public function __construct() {
        parent::__construct(
            'GDForm_Widget',
            __( 'GrandWP Forms', GDFRM_TEXT_DOMAIN ),
            array( 'description' => __( 'GrandWP Forms', GDFRM_TEXT_DOMAIN ), )
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        extract( $args );

        if ( isset( $instance['gdfrm_form_id'] ) && (absint($instance['gdfrm_form_id'])==$instance['gdfrm_form_id']) ) {
            $gdfrm_form_id = $instance['gdfrm_form_id'];

            $title = apply_filters( 'widget_title', $instance['title'] );

            if ( ! empty( $title ) ) {
                echo  $title ;
            }

            echo do_shortcode( "[gdfrm_form id='{$gdfrm_form_id}']" );
        } else{
            echo __('Select Form to Display',GDFRM_TEXT_DOMAIN);
        }
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance             = array();
        $instance['gdfrm_form_id'] = strip_tags( $new_instance['gdfrm_form_id'] );
        $instance['title']    = strip_tags( $new_instance['title'] );

        return $instance;
    }

    /**
     * @param array $instance
     * @var $instance
     * @return string|void
     */
    public function form( $instance ) {
        $formInstance = ( isset( $instance['gdfrm_form_id'] ) ? $instance['gdfrm_form_id'] : 0 );
        $title        = ( isset( $instance['title'] ) ? $instance['title'] : '' );

        View::render('admin/Widgets/FormWidget.php',array('widget'=>$this,'title'=>$title ,'formInstance'=>$formInstance));
    }
}