<?php
/**
 * @var $field \GDForm\Models\Fields\Date
 */
?>
<div class="gdfrm-form-field  <?php echo $field->fieldClass();?> ">
    <label>
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>
    <div>
        <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
        <input type="text" format="<?php echo $field->getDateFormat();?>"
               min-date="<?php echo $field->getMinDate();?>" max-date="<?php echo $field->getMaxDate();?>"
               class="grandwpdatepicker <?php echo $field->getClass();?>" name="field-<?php echo $field->getId();?>"
               placeholder="<?php echo $field->getPlaceholder();?>" value="<?php echo $field->getDefaultFormattedDate();?>"
               id="datepicker-<?php echo $field->getId();?>">
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>
</div>
