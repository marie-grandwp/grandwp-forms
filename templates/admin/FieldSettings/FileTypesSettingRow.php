<?php
/**
 * @var $field \GDForm\Models\Fields\Upload
 */
echo  '<div class="setting-row"><label>Allowed File Types</label><input class="setting-input" type="text" name="file_types-'.$field->getId().'" value="' . $field->getFileTypes() . '"></div>';
