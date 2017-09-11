<?php
/**
 * @var $field \GDForm\Models\Fields\Upload
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?> ">
            <label><?php echo $field->getLabel();?></label>
<div>
    <label for="file"><span><?php _e('Select Files',GDFRM_TEXT_DOMAIN);?></span></label>
    <input type="file" name="field-<?php echo $field->getId();?>[]" id="file" accept="<?php echo $field->getFileTypes();?>" class="gdfrm-inputfile" <?php if($field->getMultipleUpload()):?> data-multiple-caption="{count} files selected" multiple="multiple"  <?php endif;?>/>
    <div class="selected-files"></div>
    <?php $field->helpTextBlock();?>
    <?php $field->errorTextBlock();?>
</div>
</div>