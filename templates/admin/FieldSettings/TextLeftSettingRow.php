<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
echo  '<div class="setting-row"><label>Text While Typing</label><input type="text" class="setting-limit setting-input" name="limitText-'.$field->getId().'" value="'.$field->getLimitText().'" placeholder="ex. Words Left"></div>';

