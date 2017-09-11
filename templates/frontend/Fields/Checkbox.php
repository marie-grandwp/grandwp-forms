<?php
/**
 * @var $field \GDForm\Models\Fields\Checkbox
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>  option-<?php echo $field->getOptionType();?>">

    <label for="">
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>

    <div class="gdfrm-checkbox-options" data-max-sel="<?php echo $field->getLimitSelected();?>">
        <?php $options = $field->getOptions();
        foreach ( $options as $option){ ?>
            <div class="gdfrm-checkbox-option <?php echo $field->getClass();?>">
                <input type="checkbox"
                    <?php echo ($option->getChecked())?'checked':'';?> name="field-<?php echo $field->getId();?>[]" id="option-<?php echo $option->getId();?>" value="<?php echo ($option->getValue())?$option->getValue():$option->getName();?>">
                <label for="option-<?php echo $option->getId();?>"><span><?php echo $option->getName();?></span></label>
            </div>
        <?php } ?>
    </div>
    <?php $field->helpTextBlock();?>
    <?php $field->errorTextBlock();?>
</div>

