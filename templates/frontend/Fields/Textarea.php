<?php
/**
 * @var $field \GDForm\Models\Fields\Textarea
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>">
    <label for="field-<?php echo $field->getId();?>">
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>
    <div>
        <div class="hidden-placeholder"><?php echo $field->getLabel();?></div>
        <textarea id="field-<?php echo $field->getId();?>" style="height:<?php echo $field->getHeight();?>px" <?php if($field->getDisabled()):?>readonly<?php endif;?>
                  limit="<?php echo $field->getLimitNumber();?>" limitType="<?php echo $field->getLimitType();?>"
                  placeholder="<?php echo $field->getPlaceholder(); ?>" class="<?php echo $field->getClass();?>
                          <?php if(!$field->getResizable()):?>non-resizable<?php endif;?>" name="field-<?php echo $field->getId();?>"><?php echo $field->getDefaultValue();?></textarea>

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
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>
</div>
