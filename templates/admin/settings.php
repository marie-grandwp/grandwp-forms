<?php
/**
 * Template for GrandWP Forms Settings Page
 */
global $wpdb;
?>

<div class="wrap" id="gdfrm-settings">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('Plugin Settings',GDFRM_TEXT_DOMAIN);?></span>

        <ul>
            <li>
                <a href="http://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_content">

        <div class="gdfrm-list-header">
            <span id="save-form-button"><?php _e('Save');?></span>
        </div>

        <form id="grand-form">
            <div class="one-third">
                <!-- Recaptcha -->
                <div class="setting-block">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/recaptcha-logo.png';?>">
                        <?php _e('Regular Recaptcha',GDFRM_TEXT_DOMAIN);?>
                    </div>
                    <div class="help-block" >
                        ReCaptcha is a Free Google Service, protecting your website from spam and other abuse. Set up ReCaptcha keys <a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">here</a> in order to use it in your forms.
                    </div>
                    <div class="setting-row">
                        <label id="recaptcha-public-key"><?php _e('Site Key',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" value="<?php echo \GDForm()->Settings->get('RecaptchaPublicKey'); ?>" name="RecaptchaPublicKey" id="recaptcha-public-key">
                    </div>

                    <div class="setting-row">
                        <label for="recaptcha-secret-key"><?php _e('Secret Key',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" value="<?php echo \GDForm()->Settings->get('RecaptchaSecretKey'); ?>" name="RecaptchaSecretKey" id="recaptcha-secret-key">
                    </div>
                </div>

                <!-- Recaptcha -->
                <div class="setting-block">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/recaptcha-logo.png';?>">
                        <?php _e('Invisible ReCaptcha',GDFRM_TEXT_DOMAIN);?>
                    </div>
                    <div class="setting-row">
                        <label for="hidden-recaptcha-public-key"><?php _e('Site Key',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" value="<?php echo \GDForm()->Settings->get('HiddenRecaptchaPublicKey'); ?>" name="HiddenRecaptchaPublicKey" id="hidden-recaptcha-public-key">
                    </div>

                    <div class="setting-row">
                        <label for="hidden-recaptcha-secret-key"><?php _e('Secret Key',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" value="<?php echo \GDForm()->Settings->get('HiddenRecaptchaSecretKey'); ?>" name="HiddenRecaptchaSecretKey" id="hidden-recaptcha-secret-key">
                    </div>
                </div>

                <!-- PayPal Settings -->
                <div class="setting-block pro-feature">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/paypal-logo.png';?>">
                        <?php _e('Paypal Settings',GDFRM_TEXT_DOMAIN);?>
                    </div>

                    <div class="help-block" >
                        Use PayPal to get Payments/Donations From Your Users. Set up PayPal keys <a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">here</a> in order to use it in your forms.
                    </div>

                    <div class="setting-row">
                        <label for="paypal-business-email"><?php _e('PayPal Account Email',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" disabled id="paypal-business-email">
                    </div>

                    <div class="setting-row">
                        <label for="paypal-return-url"><?php _e('Return URL',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" disabled id="paypal-return-url">
                    </div>

                    <div class="setting-row">
                        <label for="paypal-currency"><?php _e('Currency',GDFRM_TEXT_DOMAIN);?></label>
                        <select id="paypal-currency" disabled>
                            <option>USD</option>
                        </select>
                    </div>
                </div>

                <div class="setting-block pro-feature">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/paypal-logo.png';?>">
                        <?php _e('Sandbox Settings',GDFRM_TEXT_DOMAIN);?>
                    </div>
                    <div class="help-block">
                        The PayPal Sandbox is a self-contained, virtual testing environment that mimics the live PayPal production environment.
                        It provides a shielded space where you can initiate and watch your application process the requests you make to the PayPal APIs without
                        touching any live PayPal accounts.
                        If you don't have a test account, you can create one <a target="_blank" href="https://developer.paypal.com/docs/classic/lifecycle/sb_create-accounts/">HERE</a>.
                        If you already have an account, you can get your API credentials <a target="_blank" href="https://developer.paypal.com/docs/classic/lifecycle/sb_credentials/">HERE</a>.
                    </div>
                    <div class="setting-row">
                        <label for="sandbox-business-email"><?php _e('Sandbox Account Email',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" disabled  id="sandbox-business-email">
                    </div>
                </div>
                <!-- end PayPal -->


            </div>

            <div class="one-third">
                <!-- Posts per page -->
                <div class="setting-block">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/checkbox.png';?>">
                        <?php _e('Forms Per Page',GDFRM_TEXT_DOMAIN);?>
                    </div>

                    <div class="setting-row">
                        <input type="number" min="2" max="100" name="PostsPerPage" placeholder="default 25" id="posts-per-page" value="<?php echo \GDForm()->Settings->get('PostsPerPage');?>">
                    </div>
                </div>

                <!-- Google Map -->
                <div class="setting-block pro-feature">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/gmap-logo.png';?>">
                        <?php _e('Google Map',GDFRM_TEXT_DOMAIN);?>
                    </div>
                    <div class="help-block">
                        Get Google Map API Key <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>
                    </div>
                    <div class="setting-row">
                        <label for="gmap-api-key"><?php _e('Api Key',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text"  id="gmap-api-key" disabled>
                    </div>
                </div>
            </div>

            <div class="one-third">
                <!-- Uninstall -->
                <div class="setting-block">
                    <div class="setting-block-title">
                        <img src="<?php echo GDFRM_IMAGES_URL.'icons/uninstall.png';?>">
                        <?php _e('Uninstall',GDFRM_TEXT_DOMAIN);?>
                    </div>

                    <div class="setting-row">
                        <label class="switcher switch-checkbox" for="remove-tables-uninstall"><?php _e('Remove all data on plugin uninstall',GDFRM_TEXT_DOMAIN);?><input type="hidden" name="RemoveTablesUninstall" value="off" /><input type="checkbox"  class="switch-checkbox" <?php checked('on',\GDForm()->Settings->get('RemoveTablesUninstall'))?> name="RemoveTablesUninstall"  id="remove-tables-uninstall"><span class="switch" ></span></label>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
<?php
?>