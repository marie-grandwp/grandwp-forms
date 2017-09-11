<?php

namespace GDForm\Models\Fields;

use GDForm\Controllers\EmailController;
use GDForm\Helpers\View;

class Email extends Field
{
    public function settingsBlock()
    {
        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';

        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DefaultSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/PlaceholderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RequiredSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ReadonlySettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Email.php',array('field'=>$this));
    }

    /**
     * validate email field
     * @param $data
     * @return true/false
     */
    public function validate( $data )
    {
        if(isset($data['field-'.$this->Id]) && $data['field-'.$this->Id]!=''){
            $value = $data['field-'.$this->Id];
            if ( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
                if($this->getFormObject()->getEmailFormatError() == ''){
                    return __( 'Invalid email format', GDFRM_TEXT_DOMAIN ) ;
                } else{
                    return $this->getFormObject()->getEmailFormatError();
                }
            } else {
                EmailController::setProperty('UserEmail',$value);
            }
        }
        return true;
    }

}