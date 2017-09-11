<?php
/**
 * @var $field \GDForm\Models\Fields\Text
 */
$html = '<div class="setting-row"><label class="full-width">Limit Input to</label>';
    $html .= '<input type="number" placeholder="ex 10" class="setting-limit setting-input one-half" name="limit-'.$field->getId().'" value="'.$field->getLimitNumber().'">';
    if($field->getType()->getName()!='password'){
        $html .= '<select name="limitType-'.$field->getId().'" class="one-half"><option value="char" '.selected('char',$field->getLimitType(),false).'>Characters</option><option value="word" '.selected('word',$field->getLimitType(),false).'>Words</option></select>';
    } else {
        $html .= '<select name="limitType-'.$field->getId().'" class="one-half"><option value="char" '.selected('char',$field->getLimitType(),false).'>Characters</option><option disabled value="word" '.selected('word',$field->getLimitType(),false).'>Words</option></select>';
    }
    $html .='</div>';

echo  $html;
