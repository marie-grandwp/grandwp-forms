<?php
/**
 * @var $field \GDForm\Models\Fields\Email
 */
?>

<div class="gdfrm-form-field <?php echo $field->fieldClass();?> ">
    <label for="field-<?php echo $field->getId();?>">
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>
    <div>
        <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
        <input id="field-<?php echo $field->getId();?>" <?php if($field->getDisabled()):?>readonly<?php endif;?> type="email"
               class="<?php echo $field->getClass();?>" placeholder="<?php echo $field->getPlaceholder();?>"
               value="<?php echo $field->getDefaultValue();?>" name="field-<?php echo $field->getId();?>" >
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>
</div>
