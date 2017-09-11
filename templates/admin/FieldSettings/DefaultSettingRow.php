<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
if( !property_exists($field,'MaskOn') || (property_exists($field,'MaskOn') && !$field->getMaskOn())){
    $readonly = '';
} else{
    $readonly = 'readonly';
}

$class = '';
if($field->getType()->getName()=='date'){
    $class = 'datepicker';
}
echo  '<div class="setting-row setting-default '.$readonly.'"><label>Default Value</label> <input type="text" class="setting-input setting-default '.$class.'" name="default-' . $field->getId() . '" value="' . esc_html($field->getDefaultValue()) . '"></div>';