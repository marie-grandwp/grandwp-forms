<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
?>
<div class="setting-row">
    <label><?php _e('Container Class', GDFRM_TEXT_DOMAIN) ?> </label>
    <input type="text" class="setting-input setting-cont-class" name="contclass-<?php echo  $field->getId(); ?>" value="<?php echo   $field->getContainerClass(); ?>" title="setting-container-class"></div>
