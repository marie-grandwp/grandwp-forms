<?php
/**
 * Template for choosing a new form template
 */
global $wpdb;

?>
<div class="wrap gdfrm_edit_form_container ">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('Form Templates',GDFRM_TEXT_DOMAIN);?></span>

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

        <div class="grand_form_template">
            <img src="<?php echo GDFRM_IMAGES_URL.'themes/theme1.png';?>" class="grand_form_template_thumb">
            <span class="grand_form_template_name">Contact Us</span>
        </div>

        <div class="grand_form_template">
            <img src="<?php echo GDFRM_IMAGES_URL.'themes/theme2.png';?>" class="grand_form_template_thumb">
            <span class="grand_form_template_name">Log In</span>
        </div>

        <div class="grand_form_template">
            <img src="<?php echo GDFRM_IMAGES_URL.'themes/theme3.png';?>" class="grand_form_template_thumb">
            <span class="grand_form_template_name">Sign Up</span>
        </div>

        <div class="grand_form_template">
            <img src="<?php echo GDFRM_IMAGES_URL.'themes/theme2.png';?>" class="grand_form_template_thumb">
            <span class="grand_form_template_name">Feedback</span>
        </div>

        <div class="grand_form_template">
            <img src="<?php echo GDFRM_IMAGES_URL.'themes/theme1.png';?>" class="grand_form_template_thumb">
            <span class="grand_form_template_name">Feedback</span>
        </div>
    </div>

</div>