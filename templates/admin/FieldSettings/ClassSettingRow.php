<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
?>
<div class="setting-row"><label><?php _e('Element Class',GDFRM_TEXT_DOMAIN); ?> </label><input type="text" class="setting-input setting-class" name="class-<?php echo  $field->getId(); ?>" value="<?php echo  $field->getClass(); ?>" title="setting-row" /></div>