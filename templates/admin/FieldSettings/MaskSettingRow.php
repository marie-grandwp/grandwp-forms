<?php
/**
 * @var $field
 *
 */
$html = '<div class="setting-row">';
    $html .= '<label for="mask-'.$field->getId().'"><span class="checkbox-label">Mask on</span><input type="checkbox" id="mask-'.$field->getId().'" class="switch-checkbox mask-switch" '.checked('1',$field->getMaskOn(),false).' name="mask_on-'.$field->getId().'"><span class="switch"></span></label>';
    $readonly = ($field->getMaskOn())?'':'readonly';
    $html .= '<div class="description '.$readonly.'">
        <input class="mask-pattern "  type="text" placeholder="Mask Pattern (ex. (99)-999-99-9) " name="maskPattern-'.$field->getId().'" value="'.$field->getMaskPattern().'">
        <b>a</b> - Represents an alpha character (A-Z,a-z)<br>
        <b>9</b> - Represents a numeric character (0-9)<br>
        <b>*</b> - Represents an alphanumeric character (A-Z,a-z,0-9)</div></div>';
echo  $html;
