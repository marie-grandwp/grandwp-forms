<?php
/**
 * @var $field \GDForm\Models\Fields\Recaptcha;
 * @var $recaptchaSecretKey;
 * @var $recaptchaPublicKey;
 */
wp_enqueue_script( 'gdfrm_recaptcha', 	'https://www.google.com/recaptcha/api.js', array( 'jquery' ), '1.0.0', true );
?>
    <div class="gdfrm-form-field <?php echo $field->fieldClass();?>">
        <?php if($field->getRecaptchaType()=='regular' && $recaptchaPublicKey && $recaptchaSecretKey ):?>
            <label for=""><?php echo $field->getLabel();?></label>
            <div class="gdfrm-captcha-block" data-form-id='<?php echo $field->getForm();?>' >
                <div id="gdfrm-<?php echo $field->getForm();?>-recaptcha" theme="<?php echo $field->getRecaptchaStyle();?>" sitekey="<?php echo $recaptchaPublicKey;?>" ></div>
            </div>
            <?php $field->helpTextBlock();?>
            <?php $field->errorTextBlock();?>
        <?php elseif($field->getRecaptchaType()=='regular' && (!$recaptchaPublicKey || !$recaptchaSecretKey) ): ?>
            <div class="gdfrm-notice">
                <i class="fa fa-exclamation-triangle"></i> <?php _e('Configure ReCaptcha Settings in Plugin Settings Page',GDFRM_TEXT_DOMAIN);?>
            </div>
        <?php endif;?>
    </div>
