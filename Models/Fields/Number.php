<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Number extends Field
{
    protected static $dbFields = array(
        'Label',
        'Ordering',
        'LabelPosition',
        'DefaultValue',
        'Class',
        'ContainerClass',
        'Placeholder',
        'HelperText',
        'Required',
        'Disabled',
        'Form',
        'Minimum',
        'Maximum',
        'NumberType',
        'TypeId'
    );

    private $Minimum;

    private $Maximum;

    private $NumberType;

    /**
     * @return int
     */
    public function getMaximum()
    {
        return $this->Maximum;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setMaximum( $value ) {
        if( absint($value) == $value){

            $this->Maximum = intval( $value );
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimum()
    {
        return $this->Minimum;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setMinimum( $value ) {
        if( absint($value) == $value){

            $this->Minimum = intval( $value );
        }

        return $this;
    }

    /**
     * @return string int/float
     */
    public function getNumberType()
    {
        return $this->NumberType;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setNumberType( $value ) {
        if(in_array($value,array('int','float'))){

            $this->NumberType =  $value ;

        }

        return $this;
    }

    public function settingsBlock()
    {
        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';

        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DefaultSettingRow.php', array('field'=>$this));
        $settings_block_html .= '<div class="setting-row"><label class="full-width">Min/Max Values</label><input type="number" class="setting-min one-half" placeholder="Min Value" name="min-'.$this->Id.'" value="'.$this->Minimum.'"><input type="number" class="setting-max one-half" placeholder="Max Value" name="max-'.$this->Id.'" value="'.$this->Maximum.'"></div>';
        $settings_block_html .= '<div class="setting-row"><label for="">Number Type</label><select name="numberType-'.$this->Id.'"><option value="int" '.selected('int',$this->NumberType,false).'>Integer</option><option value="float" '.selected('float',$this->NumberType,false).'>Float</option></select></div>';
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
        View::render('frontend/Fields/Number.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setMinimum($fields_settings['min-'.$field_id]);
        $this->setMaximum($fields_settings['max-'.$field_id]);
        $this->setNumberType($fields_settings['numberType-'.$field_id]);

    }


}