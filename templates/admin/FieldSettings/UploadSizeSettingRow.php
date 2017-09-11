<?php
/**
 * @var $field \GDForm\Models\Fields\Upload
 */

echo  '<div class="setting-row"><label>Max Upload Size(mb)</label><input class="setting-input" type="number" name="upload_size-'.$field->getId().'" value="' . $field->getUploadSize() . '"></div>';
