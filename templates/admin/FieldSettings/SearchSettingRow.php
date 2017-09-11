<?php
/**
 * @var $field \GDForm\Models\Fields\Selectbox
 */
echo  '<div class="setting-row"><label for="searchOn-'.$field->getId().'">Search On <input type="checkbox" class="setting-input switch-checkbox" '.checked('1',$field->getSearchOn(),false).' name="searchOn-'.$field->getId().'" id="searchOn-'.$field->getId().'"><span class="switch" ></span></label></div>';
