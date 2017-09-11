<?php
/**
 * @var $field \GDForm\Models\Fields\Radio
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?> option-<?php echo $field->getOptionType();?>">

    <label for=""><?php echo $field->getLabel();?></label>
    <div class="gdfrm-radio-options">
        <?php $options = $field->getOptions();
        foreach ( $options as $key => $option){ ?>
            <div class="gdfrm-radio-option <?php echo $field->getClass();?>">
                <input type="radio" <?php echo ($key==0)?'checked':'';?> name="field-<?php echo $field->getId();?>" id="option-<?php echo $option->getId();?>" value="<?php echo ($option->getValue())?$option->getValue():$option->getName();?>">
                <label for="option-<?php echo $option->getId();?>"><span><?php echo $option->getName();?></span></label>
            </div>
        <?php } ?>
    </div>
    <?php $field->helpTextBlock();?>
    <?php $field->errorTextBlock();?>
</div>
