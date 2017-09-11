<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
echo  '<div class="setting-row"><label>Help Text </label><textarea class="setting-input setting-help-text" name="helptext-'.$field->getId().'" >'.$field->getHelperText().'</textarea></div>';