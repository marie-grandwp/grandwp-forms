<?php
/**
 * @var $widget \GDForm\Controllers\Widgets\FormWidgetController
 * @var $title
 * @var $formInstance
 *
 */
?>
<p>

<p>
    <label for="<?php echo $widget->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $widget->get_field_id( 'title' ); ?>"
           name="<?php echo $widget->get_field_name( 'title' ); ?>" type="text"
           value="<?php echo esc_attr( $title ); ?>"/>
</p>
<label for="<?php echo $widget->get_field_id( 'gdfrm_form_id' ); ?>"><?php _e( 'Select Form:', GDFRM_TEXT_DOMAIN ); ?></label>
<select id="<?php echo $widget->get_field_id( 'gdfrm_form_id' ); ?>" name="<?php echo $widget->get_field_name( 'gdfrm_form_id' ); ?>">
    <?php
    $forms = \GDForm\Models\Form::get();

    if( $forms ){
        foreach( $forms as $form ){
            ?>
            <option <?php echo selected( $formInstance, $form->getId() ); ?> value="<?php echo $form->getId(); ?>">
                <?php echo $form->getName(); ?>
            </option>
            <?php
        }
    }
    ?>
</select>

</p>
