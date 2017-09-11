<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;


class Upload extends Field
{
    /**
     * File Types
     *
     * @var string
     */
    protected $FileTypes = '.jpeg,.png,.docx,.pdf,.txt,.csv,.ppt';

    /**
     * Max Upload Size
     *
     * @var int
     */
    protected $UploadSize = 2;

    /**
     * Multiple Upload off|on
     *
     * @var int 0|1
     */
    protected $MultipleUpload = 0;

    /**
     * @return string
     */
    public function getFileTypes()
    {
        return $this->FileTypes;
    }

    /**
     * @param string $value
     *
     * @return Upload
     */
    public function setFileTypes( $value ) {

        $this->FileTypes =  sanitize_text_field( $value ) ;


        return $this;
    }

    /**
     * @return int
     */
    public function getUploadSize()
    {
        return $this->UploadSize;
    }

    /**
     * @param int $value
     *
     * @return Upload
     */
    public function setUploadSize( $value ) {
        if(absint($value)==$value){

            $this->UploadSize =  $value ;

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMultipleUpload()
    {
        return $this->MultipleUpload;
    }

    /**
     * @param string $value
     *
     * @return Upload
     */
    public function setMultipleUpload( $value ) {

        if(in_array($value,array(0,1,'on'))){

            if($value=='on') $value=1;
            $this->MultipleUpload = intval( $value );

        }

        return $this;

    }

    public function settingsBlock()
    {

        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/FileTypesSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/UploadSizeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/MultiUploadSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
       View::render('frontend/Fields/Upload.php',array('field'=>$this));
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);
        $this -> setFileTypes($fields_settings['file_types-'.$field_id])
              -> setUploadSize($fields_settings['upload_size-'.$field_id])
              -> setMultipleUpload($fields_settings['multiple_upload-'.$field_id]);
    }


    /**
     * validate upload field
     * @param $data
     * @return true/false
     */
    public function validate( $data )
    {
        if(isset($data['name'])){
            $size = $data['size']/(1024*1024);
            if($size>$this->getUploadSize()){
                $error = array(
                    'field'=>$this->Id,
                    'error'=>($this->getFormObject()->getUploadSizeError())?$this->getFormObject()->getUploadSizeError():'Max Upload Size Exceeded'
                );

                return $error;
            }
        }
        return true;
    }


}