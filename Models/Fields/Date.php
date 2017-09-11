<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Date extends Field
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
        'MinDate',
        'MaxDate',
        'DateFormat',
        'TypeId'
    );

    /**
     * Minimum Date user can select
     *
     * @var string
     */
    private $MinDate;

    /**
     * Maximum Date user can select
     *
     * @var string
     */
    private $MaxDate;

    /**
     * Date Format
     *
     * @var string
     */
    private $DateFormat;

    public function getDefaultFormattedDate()
    {
        $default = $this->DefaultValue;

        switch($this->DateFormat){
            case 'dd-mm-yy':
                $format = 'd-m-y';
                break;
            case 'dd/mm/yy':
                $format = 'd/m/y';
                break;
            case 'd M,y':
                $format = 'd M,y';
                break;
            case 'd M,yy':
                $format = 'd M,Y';
                break;
            default:
                $format = 'd-m-y';
        }

        if($default){
            $date_to_number = strtotime($default);

            $date = date($format,$date_to_number);
        } else {
            $date =  '';
        }


        return $date;
    }

    /**
     * Min date user can select
     *
     * @return string
     */
    public function getMinDate()
    {
        return $this->MinDate;
    }

    /**
     * Min date user can select
     *
     *
     * @return Date
     */
    public function setMinDate($value)
    {
        if($value){
            $time = strtotime($value);

            $newformat = date('Y-m-d', $time);

            if ($newformat) {
                $this->MinDate = $newformat;
            }
        } else{
            $this->MinDate = '';
        }
        return $this;
    }

    /**
     * Max date user can select
     *
     * @return string
     */
    public function getMaxDate()
    {
        return $this->MaxDate;
    }

    /**
     * Max date user can select
     *
     * @var string $value
     *
     * @return Date
     */
    public function setMaxDate($value)
    {
        if($value){
            $time = strtotime($value);

            $newformat = date('Y-m-d', $time);

            if ($newformat) {
                $this->MaxDate = $newformat;
            }
        } else{
            $this->MaxDate = '';
        }

        return $this;
    }

    /**
     * Date Format for datepicker
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->DateFormat;
    }

    /**
     * Date format for datepicker
     *
     * @return Date
     */
    public function setDateFormat($value)
    {
        if(in_array($value,array('dd-mm-yy','dd/mm/yy','d M,y','d M,yy'))){
            $this->DateFormat = $value;
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
        $settings_block_html .= View::buffer('admin/FieldSettings/PlaceholderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DateRangeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/DateFormatSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RequiredSettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Date.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setMinDate($fields_settings['min_date-'.$field_id]);
        $this->setMaxDate($fields_settings['max_date-'.$field_id]);
        $this->setDateFormat($fields_settings['date_format-'.$field_id]);

    }


}