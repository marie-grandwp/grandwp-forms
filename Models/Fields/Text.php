<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Text extends Field
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
        'LimitNumber',
        'LimitType',
        'LimitText',
        'MaskOn',
        'MaskPattern',
        'TypeId'
    );

    /**
     * Limit input length
     *
     * @var int
     */
    private $Limit;

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
     * Mask enabled|disabled
     *
     * @var $mask_on int 0|1
     */
    private $MaskOn;

    /**
     * Mask pattern
     *
     * @var string
     */
    private $MaskPattern;

    /**
     * @return int
     */
    public function getMaskOn()
    {
        return $this->MaskOn;
    }

    /**
     * @param int $value
     *
     * @return Text
     */
    public function setMaskOn( $value ) {
        if(in_array($value,array(0,1,'on'))){

            if($value=='on') $value=1;
            $this->MaskOn = intval( $value );

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMaskPattern()
    {
        return $this->MaskPattern;
    }

    /**
     * @param string $value
     *
     * @return Text
     */
    public function setMaskPattern( $value ) {
        $this->MaskPattern = sanitize_text_field( $value );

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
     * @return Text
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
     * @return Text
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
     * @return Text
     */
    public function setLimitText( $value )
    {
        $this->LimitText = sanitize_text_field( $value );

        return $this;
    }

    public function settingsBlock()
    {
        $settings_block_html  = '<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DefaultSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/MaskSettingRow.php', array('field'=>$this));
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
        View::render('frontend/Fields/Text.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setLimitNumber($fields_settings['limit-'.$field_id]);
        $this->setLimitType($fields_settings['limitType-'.$field_id]);
        $this->setLimitText($fields_settings['limitText-'.$field_id]);
        $this->setMaskOn($fields_settings['mask_on-'.$field_id]);
        $this->setMaskPattern($fields_settings['maskPattern-'.$field_id]);

    }
}