<?php
/**
 * @var $field \GDForm\Models\Fields\Field
 */

$html = '';
if($field->getType()->getName() == 'recaptcha'){
    if( \GDForm()->Settings->get('RecaptchaPublicKey')=='' || \GDForm()->Settings->get('RecaptchaSecretKey')=='' || \GDForm()->Settings->get('HiddenRecaptchaPublicKey')=='' || \GDForm()->Settings->get('HiddenRecaptchaSecretKey')==''){
        $html .= '<div class="notice">'.__('Configure ReCaptcha Settings ',GDFRM_TEXT_DOMAIN). '<a target="_blank" href="'.admin_url('admin.php?page=gdfrm_settings').'">'.__('Here',GDFRM_TEXT_DOMAIN).'</a>'.__(' in Order to Use it ',GDFRM_TEXT_DOMAIN).'</div>';
    }
} else if($field->getType()->getName() == 'map'){
    if( \GDForm()->Settings->get('GmapApiKey')==''){
        $html .= '<div class="notice">'.__('Configure Map Settings',GDFRM_TEXT_DOMAIN). '<a target="_blank" href="'.admin_url('admin.php?page=gdfrm_settings').'">'.__('Here',GDFRM_TEXT_DOMAIN).'</a>'.__(' in Order to Use it ',GDFRM_TEXT_DOMAIN). '</div>';
    }
}

echo  $html;