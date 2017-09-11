<?php
/**
 * @var $field \GDForm\Models\Fields\Text
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?> ">
            <label for="field-<?php echo $field->getId();?>">
                <?php echo $field->getLabel();?>
<?php echo $field->requiredBlock();?>
</label>

<div>
    <?php if($field->getMaskOn()):?>
        <input id="field-<?php echo $field->getId();?>" <?php if($field->getDisabled()):?>readonly<?php endif;?>
               type="text"  data-pattern="<?php echo $field->getMaskPattern();?>"
               class="masked <?php echo $field->getClass();?>" placeholder="<?php echo $field->getMaskPattern();?>" name="field-<?php echo $field->getID();?>">
    <?php else: ?>
        <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
        <input id="field-<?php echo $field->getId();?>"
               <?php if($field->getDisabled()):?>readonly<?php endif;?> type="text"
               limit="<?php echo $field->getLimitNumber();?>" limitType="<?php echo $field->getLimitType();?>"
               placeholder="<?php echo $field->getPlaceholder();?>" class="<?php echo $field->getClass();?>"
               name="field-<?php echo $field->getId();?>" value="<?php echo $field->getDefaultValue();?>">

        <?php if($field->getLimitNumber()) : ?>
            <p class="limit-text">
                <span class="left"><?php echo $field->getLimitNumber();?></span> of
                <span class="total"><?php echo $field->getLimitNumber();?></span>
                <?php if($field->getLimitText()):?>
                    <?php echo $field->getLimitText();?>
                <?php else:?>
                    <?php echo $field->getLimitType();?>(s) Left
                <?php endif;?>
            </p>
        <?php endif; ?>
    <?php endif;?>

    <?php $field->helpTextBlock();?>
    <?php $field->errorTextBlock();?>
</div>
</div>