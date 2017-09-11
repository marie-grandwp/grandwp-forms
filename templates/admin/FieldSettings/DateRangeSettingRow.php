<?php
/**
 * @var $field \GDForm\Models\Fields\Date
 */
$html = '<div class="setting-row">';
$html .= '<div class="one-half"><label>Min</label><input type="text" value="'.$field->getMinDate().'" placeholder="min date" name="min_date-'.$field->getId().'" class="datepicker"></div>';
$html .= '<div class="one-half"><label>Max</label><input type="text" value="'.$field->getMaxDate().'" placeholder="max date" name="max_date-'.$field->getId().'" class="datepicker"></div></div>';
echo  $html;