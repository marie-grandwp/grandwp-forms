<?php
/**
 * @var $field \GDForm\Models\Fields\Textarea
 */
$height = ($field->getHeight())?$field->getHeight():'100';
echo  '<div class="setting-row"><label>Height in px</label><input type="number" class="setting-input " name="height-' . $field->getId() . '" value="' . $height . '"></div>';