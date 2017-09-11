<?php
/**
 * @var $field \GDForm\Models\Fields\Phone
 *
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>">
    <label for="field-<?php echo $field->getId();?>">
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>
    <div>
        <?php if($field->getMaskOn()):?>
            <input id="field-<?php echo $field->getId();?>" type="tel"
                   <?php if($field->getDisabled()):?>readonly<?php endif;?>
                   placeholder="<?php echo $field->getMaskPattern();?>" data-pattern="<?php echo $field->getMaskPattern();?>"
                   class="masked <?php echo $field->getClass();?>"
                   name="field-<?php echo $field->getId();?>" >
        <?php else: ?>
            <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
            <input <?php if($field->getDisabled()):?>readonly<?php endif;?> id="field-<?php echo $field->getId();?>" type="tel"
                   placeholder="<?php echo $field->getPlaceholder();?>"  class="<?php echo $field->getClass();?>"
                   value="<?php echo $field->getDefaultValue();?>"
                   name="field-<?php echo $field->getId();?>" >
        <?php endif;?>
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>

</div>
