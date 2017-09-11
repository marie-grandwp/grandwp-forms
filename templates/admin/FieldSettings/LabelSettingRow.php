<?php
/**
 * @var $field GDForm\Models\Fields\Field
 */
?>
<div class="setting-row">
    <label><?php _e('Label',  GDFRM_TEXT_DOMAIN); ?> </label>
    <input type="text" class="setting-label setting-input " name="label-<?php echo  $field->getId(); ?>" value="<?php echo  $field->getLabel(); ?>" title="setting-label">
</div>
