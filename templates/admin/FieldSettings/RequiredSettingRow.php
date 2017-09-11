<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */

echo  '<div class="setting-row"><label for="required-'.$field->getId().'">'.__('Required',GDFRM_TEXT_DOMAIN).' <input type="checkbox" class="setting-input setting-required switch-checkbox" '.checked('1',$field->getRequired(),false).' name="required-'.$field->getId().'" id="required-'.$field->getId().'"><span class="switch" ></span></label></div>';
