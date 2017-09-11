<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */

$html ='<div class="setting-row options">';

$field_options = $field->getOptions();

foreach ($field_options as $field_option){
    $html.= $field_option->optionRow();
}
$html.='</div>';

echo  $html;