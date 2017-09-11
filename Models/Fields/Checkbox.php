<?php

namespace GDForm\Models\Fields;


use GDForm\Helpers\View;


class Checkbox extends Field
{
    protected static $OptionsTableName = 'GDFormFieldOptions';

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
        'OptionType',
        'LimitSelected',
        'TypeId'
    );

    /**
     * Options of current field
     * Array of GDForm_Field_Option instances
     *
     * @var FieldOption[]
     */
    private $Options;

    /**
     * Option type
     * @var string inline,block
     **/
    private $OptionType;

    /**
     * Number of options user can select
     * @var int
     **/
    private $LimitSelected;

    public function __construct($args=array())
    {
        parent::__construct($args);

        if(null !== $this->Id){
            $this->Options = $this->getOptions();
        }
    }

    public static function getOptionsTableName()
    {
        return $GLOBALS['wpdb']->prefix.static::$OptionsTableName;
    }


    /**
     * field data
     * @param null $fieldId
     * @return bool
     */
    public function save($fieldId = null)
    {
        $newField = false;
        if( $this->Id == null ) $newField = true;
        $saved = parent::save($fieldId);

        if ($saved !== false) {

            $options = $this->Options;

            foreach ($options as $option) {
                if($newField) $option->unsetId();
                $option->setField($this->Id);
                $option->save();

            }

            return $this->Id;

        } else {

            return false;

        }
    }

    public function getOptions()
    {
        if( !isset($this->Options) ){
            global $wpdb;
            $query = "SELECT * FROM " . static::getOptionsTableName() . "  WHERE Field ={$this->Id} ORDER BY Ordering";

            $options = $wpdb->get_results( $query );

            $optionsArray = array();

            foreach ( $options as $option ){
                $optionsArray[] = new FieldOption(array('Id'=>$option->Id));
            }

            $this->Options = $optionsArray;
        }

        return $this->Options;
    }

    /**
     * @param FieldOption[] $options
     *
     * @return Checkbox
     * @throws \Exception
     */
    public function setOptions( $options ) {
        foreach ( $options as $option ) {
            if ( ! ( $option instanceof FieldOption ) ) {
                throw new \Exception( 'Field must be an instance of GDForm_Field class.' );
            }

        }

        $this->Options = $options;

        return $this;
    }

    public function getOptionType()
    {

        return $this->OptionType;

    }

    /**
     * @param string $type
     *
     * @return Checkbox
     */
    public function setOptionType( $type ) {
        if( in_array($type, array('inline','block'))){

            $this->OptionType = $type;

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getLimitSelected()
    {
        return $this->LimitSelected;
    }

    /**
     * @param int $value
     *
     * @return Checkbox
     */
    public function setLimitSelected( $value ) {
        if( absint($value) == $value){

            $this->LimitSelected = intval( $value );
        }

        return $this;
    }



    public function settingsBlock()
    {

        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RequiredSettingRow.php', array('field'=>$this));

        $settings_block_html .= '<div class="setting-row"><label>'.__('Checkbox Alignment',GDFRM_TEXT_DOMAIN). '</label><select name="optionType-'.$this->Id.'" ><option value="inline" '.selected('inline',$this->OptionType,false).'>'.__('Inline',GDFRM_TEXT_DOMAIN). '</option><option value="block" '.selected('block',$this->OptionType,false).'>'.__('New Line',GDFRM_TEXT_DOMAIN). '</option></select></div>';
        $settings_block_html .= '<div class="setting-row"><i class="fa fa-tasks gdfrm-import-options nowidth" aria-hidden="true" >Import Options</i>  <i class="fa fa-plus gdfrm-add-option nowidth" aria-hidden="true" >'.__('Add Option',GDFRM_TEXT_DOMAIN).'</i></div>';
        $settings_block_html .= '<div class="setting-row import-block"><p class="description">Follow the pattern below, after you have added all options, click Import Options Button</p><textarea>{Name1#Value1},{Name2#Value2}</textarea><p><span class="import-options">'.__('Import Options',GDFRM_TEXT_DOMAIN).'</span><span class="cancel">'.__('Cancel',GDFRM_TEXT_DOMAIN).'</span></p></div>';


        $settings_block_html .='<div class="setting-row pro-feature"><label for="paymentEnabled-'.$this->getId().'">'.__('Payment Field',GDFRM_TEXT_DOMAIN).' <input type="checkbox" class="setting-input switch-checkbox payment-switch" id="paymentEnabled-'.$this->getId().'"><span class="switch" ></span></label></div>';

        $settings_block_html .= View::buffer('admin/FieldSettings/CheckboxOptionsSettingRow.php', array('field'=>$this));

        $settings_block_html .= '<div class="setting-row"><label>Limit selected options number to </label><input type="number" value="'.$this->LimitSelected.'" name="limitSelected-'.$this->Id.'"></div>';

        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Checkbox.php', array('field'=>$this));
    }


    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setOptionType($fields_settings['optionType-' . $this->Id])
            ->setLimitSelected($fields_settings['limitSelected-' . $this->Id]);

        $options = $this->Options;

        foreach ($options as $option) {

            $option->setProperties($fields_settings);

            $option->save($option->getId());

        }
    }
}