<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Html extends Field
{

    public function settingsBlock()
    {
        $SettingsBlockHtml = '<div class="settings-block" data-field-id="'.$this->Id.'">';
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));

        ob_start();
        wp_editor($this->getDefaultValue(),'default-'.$this->Id, array('editor_class'=>'setting-row'));
        $wp_editor=ob_get_clean();

        $SettingsBlockHtml .= '<div class="setting-row"><label>'.__('Code',GDFRM_TEXT_DOMAIN).'</label>'.$wp_editor.'</div>';
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $SettingsBlockHtml .= '</div>';

        return $SettingsBlockHtml;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Html.php', array('field'=>$this));
    }
}