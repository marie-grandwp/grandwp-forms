<?php
/**
 * @var $field \GDForm\Models\Fields\Captcha
 */

use GDForm\Models\Fields\Captcha;
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>">
    <label for="">
        <?php echo $field->getLabel();?>
    </label>
    <div>
        <div class="gdfrm-captcha-box clear-float <?php echo $field->getClass();?>">
            <?php $captcha = Captcha::createSimpleCaptcha($field->getId(), 'user');?>
            <input type="hidden" name="captcha-id" value="<?php echo $captcha['id'] ?>">
            <img src="<?php echo $captcha['url'] ?>">
            <a href="" captchaid="<?php echo $field->getId();?>">
                <img src="<?php echo GDFRM_IMAGES_URL;?>refresh-captcha.png">
            </a>
            <input type="text" name="field-<?php echo $field->getId()?>" placeholder="<?php echo ($field->getPlaceholder())?$field->getPlaceholder():'Type the code above';?>">
        </div>
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>
</div>
