<?php
/**
 * @var $field \GDForm\Models\Fields\Upload
 */

echo  '<div class="setting-row"><label for="multiple_upload-'.$field->getId().'"><span class="checkbox-label">Multiple Upload</span><input type="checkbox" id="multiple_upload-'.$field->getId().'" class="switch-checkbox" '.checked('1',$field->getMultipleUpload(),false).' name="multiple_upload-'.$field->getId().'"><span class="switch"></span></label></div>';
