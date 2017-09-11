<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;


class Textarea extends Field
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
        'Resizable',
        'Height',
        'LimitNumber',
        'LimitType',
        'LimitText',
        'TypeId'
    );

    /**
     * Textarea resizable
     *
     * @var int 0|1
     */
    private $Resizable;

    /**
     * Textarea height
     *
     * @var int
     */
    private $Height;

    /**
     * Limit input length
     *
     * @var int
     */
    private $LimitNumber;

    /**
     * Input limit type
     *
     * @var string char|word
     */
    private $LimitType;

    /**
     * Text while typing
     *
     * @var string
     */
    private $LimitText;


    /**
     * @return int(0,1)
     */
    public function getResizable()
    {
        return $this->Resizable;
    }

    /**
     * @param int $value (0,1)
     *
     * @return Textarea
     */
    public function setResizable( $value ) {
        if(in_array($value,array(0,1,'on'))){

            if($value=='on') $value = 1;
            $this->Resizable = intval( $value );

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->Height;
    }

    /**
     * @param int $value
     *
     * @return Textarea
     */
    public function setHeight( $value ) {
        if( absint($value) == $value){

            $this->Height = intval( $value );
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getLimitNumber()
    {
        return $this->LimitNumber;
    }

    /**
     * @param int $value
     *
     * @return Textarea
     */
    public function setLimitNumber( $value ) {
        if( absint($value) == $value){

            $this->LimitNumber = intval( $value );
        }

        return $this;
    }

    /**
     * @return string char/word
     */
    public function getLimitType()
    {
        return $this->LimitType;
    }

    /**
     * @param string $value
     *
     * @return Textarea
     */
    public function setLimitType( $value ) {
        if(in_array($value,array('char','word'))){

            $this->LimitType =  $value ;

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLimitText()
    {
        return $this->LimitText;
    }

    /**
     * @param string $value
     *
     * @return Textarea
     */
    public function setLimitText( $value )
    {
        $this->LimitText = sanitize_text_field( $value );

        return $this;
    }

    public function settingsBlock()
    {


        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DefaultSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HeightSettingRow.php', array('field'=>$this));
        $settings_block_html .= '<div class="setting-row"><label for="resizable-'.$this->Id.'">Resizable <input type="checkbox" class="setting-input setting-resizable switch-checkbox" '.checked('1',$this->Resizable,false).' name="resizable-'.$this->getId().'" id="resizable-'.$this->getId().'"><span class="switch" ></span></label></div>';

        $settings_block_html .= View::buffer('admin/FieldSettings/PlaceholderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/InputLengthSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/TextLeftSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RequiredSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ReadonlySettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Textarea.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setResizable($fields_settings['resizable-'.$field_id]);
        $this->setLimitNumber($fields_settings['limit-'.$field_id]);
        $this->setLimitType($fields_settings['limitType-'.$field_id]);
        $this->setLimitText($fields_settings['limitText-'.$field_id]);
        $this->setHeight($fields_settings['height-'.$field_id]);

    }
}