<?php
/**
 * @var $field \GDForm\Models\Fields\Number
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>">
            <label for="field-<?php echo $field->getId();?>">
                <?php echo $field->getLabel();?>
                <?php echo $field->requiredBlock();?>

            </label>

<div>
    <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
    <?php if($field->getNumberType()=='int') $step=1; else $step=0.1;?>
    <input id="field-<?php echo $field->getId();?>" <?php if($field->getDisabled()):?>readonly<?php endif;?> type="number" step="<?php echo $step;?>"
           min="<?php echo $field->getMinimum();?>"  max="<?php echo ($field->getMaximum())?$field->getMaximum():'';?>"
           class="<?php echo $field->getClass();?>" placeholder="<?php echo $field->getPlaceholder();?>"
           name="field-<?php echo $field->getId();?>" value="<?php echo $field->getDefaultValue();?>">

    <?php $field->helpTextBlock();?>
    <?php $field->errorTextBlock();?>
</div>

</div>