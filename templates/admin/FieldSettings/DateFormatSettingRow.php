<?php
/**
 * @var $field \GDForm\Models\Fields\Date
 */
$html = '<div class="setting-row"><label>Date Format</label><select name="date_format-'.$field->getId().'">';
$formats = array('dd-mm-yy','dd/mm/yy','d M,y','d M,yy');
foreach ($formats as $format){
    $html .= '<option '.selected($format,$field->getDateFormat(),false).'>'.$format.'</option>';
}
$html .= '</select></div>';

echo  $html;