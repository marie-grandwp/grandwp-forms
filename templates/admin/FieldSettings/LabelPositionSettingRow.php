<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */

$row = '<div class="setting-row"><label>'.__('Label Position',GDFRM_TEXT_DOMAIN).' </label><select class="setting-label-pos" name="position-' . $field->getId() . '" >';

$label_positions = \GDForm\Models\LabelPosition::get();
foreach ($label_positions as $position) {
    $row .= '<option value="' . $position->getId() . '" ' . selected($position->getId(), $field->getLabelPosition(), false) . '>' . strtoupper($position->getName()) . '</option>';
}

$row .= '</select></div>';

echo  $row;
