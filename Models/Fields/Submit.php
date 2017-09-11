<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Submit extends Field
{

    /**
     * @return string
     */
    public function getLabel()
    {
        if(!empty($this->Label)){
            return wp_unslash($this->Label);
        }
        else{

            return __('Submit',GDFRM_TEXT_DOMAIN);

        }
    }

    public function settingsBlock()
    {
        $SettingsBlockHtml = '<div class="settings-block" data-field-id="'.$this->Id.'">';
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= '</div>';

        return $SettingsBlockHtml;
    }

    public function fieldHtml()
    {
        $hasHiddenRecaptcha =($this->getFormObject()->getRecaptcha() == 'hidden')?true:false;
        $hiddenRecaptchaPublicKey = \GDForm()->Settings->get('HiddenRecaptchaPublicKey');
        $hiddenRecaptchaSecretKey = \GDForm()->Settings->get(('HiddenRecaptchaSecretKey'));

        View::render('frontend/Fields/Submit.php', array(
            'field'=>$this,
            'HiddenRecaptchaPublicKey'=>$hiddenRecaptchaPublicKey,
            'HiddenRecaptchaSecretKey'=>$hiddenRecaptchaSecretKey,
            'HasHiddenRecaptcha'=>$hasHiddenRecaptcha
        ));
    }

    public function fieldBlock()
    {
        $field_block_html = '<div class="field-block ui-state-default ui-sortable-handle" data-field-id="' . $this->Id . '" data-field-type="' . $this->getType()->getId() . '">';
        $field_block_html .= '<i class="gdicon gdicon-' . $this->getType()->getName() . '"></i>';
        $field_block_html .= '<span class="field_name">' . $this->getLabel() . '</span>';
        $field_block_html .= '<i class="gdicon gdicon-remove"></i><i class="gdicon gdicon-setting"></i>';
        $field_block_html .= '</div>';

        return $field_block_html;
    }

}