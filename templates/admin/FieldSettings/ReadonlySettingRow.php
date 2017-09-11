<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */

echo  '<div class="setting-row"><label for="readonly-'.$field->getId().'">'.__('Readonly',GDFRM_TEXT_DOMAIN).' <input type="checkbox" class="setting-input setting-disabled switch-checkbox" '.checked('1',$field->getDisabled(),false).' name="disabled-'.$field->getId().'" id="readonly-'.$field->getId().'"><span class="switch" ></span></label></div>';
