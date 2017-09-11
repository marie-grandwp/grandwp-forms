<?php
/**
 * @var $field \GDForm\Models\Fields\Html
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?> ">
    <label><?php echo $field->getLabel();?></label>

    <?php $field->helpTextBlock();?>

    <div class="<?php echo $field->getClass();?>">
        <?php echo do_shortcode(wp_unslash($field->getDefaultValue()));?>
    </div>
</div>