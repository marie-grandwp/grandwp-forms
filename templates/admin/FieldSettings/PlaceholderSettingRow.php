<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */
if( !property_exists($field,'MaskOn') || (property_exists($field,'MaskOn') && !$field->getMaskOn())){
    $readonly = '';
} else{
    $readonly = 'readonly';
}
$html = '<div class="setting-row setting-placeholder '.$readonly.'"><label>'.__('Placeholder',GDFRM_TEXT_DOMAIN).' </label>';
$html .= '<input type="text" class="setting-input setting-placeholder " name="placeholder-' . $field->getId() . '" value="' . $field->getPlaceholder() . '">';
$html .= '</div>';

echo  $html;