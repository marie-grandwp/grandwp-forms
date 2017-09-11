<?php
/**
 * @var $field \GDForm\Models\Fields\Submit
 * @var $HasHiddenRecaptcha bool
 * @var $HiddenRecaptchaPublicKey
 */
?>

<div class="gdfrm-form-field <?php echo $field->fieldClass();?> ">
    <?php if($HasHiddenRecaptcha) { ?>
        <input type="submit" id="gdfrm-<?php echo $field->getForm();?>-recaptcha" sitekey="<?php echo $HiddenRecaptchaPublicKey;?>" value="<?php echo $field->getLabel();?>" />
    <?php } else { ?>
        <input type="submit" id="submit-<?php echo $field->getForm();?>" class="<?php echo $field->getClass();?>" value="<?php echo $field->getLabel();?>">
    <?php } ?>
</div>
