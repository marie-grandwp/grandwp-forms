<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;
use GDForm\Models\Form;
use GDForm\Models\Settings;

class Recaptcha extends Field
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
        'RecaptchaType',
        'RecaptchaStyle',
        'TypeId'
    );

    /**
     * recaptcha_type
     *
     * @var string regular|hidden
     */
    private $RecaptchaType;

    /**
     * recaptcha_style
     *
     * @var string light|dark
     */
    private $RecaptchaStyle;

    /**
     * @return string
     */
    public function getRecaptchaType( )
    {

        return $this->RecaptchaType;

    }

    /**
     * @param string $recaptcha_type
     *
     * @return Recaptcha
     */
    public function setRecaptchaType( $recaptcha_type )
    {
        if( in_array($recaptcha_type,array('regular','hidden'))){

            $this->RecaptchaType =  $recaptcha_type ;

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRecaptchaStyle( )
    {

        return $this->RecaptchaStyle;

    }

    /**
     * @param string $recaptcha_style
     *
     * @return Recaptcha
     */
    public function setRecaptchaStyle( $recaptcha_style )
    {
        if( in_array($recaptcha_style,array('light','dark'))){

            $this->RecaptchaStyle =  $recaptcha_style ;

        }

        return $this;
    }

    public function setProperties($fields_settings, $field_id)
    {
        parent::setProperties($fields_settings, $field_id);

        $this->setRecaptchaStyle($fields_settings['recaptcha_style-'.$field_id]);
        $this->setRecaptchaType($fields_settings['recaptcha_type-'.$field_id]);

}


    /* validate recaptcha field */
    public function validate( $data ) {
        if($this->getRecaptchaType()=='regular'){
            if(isset($data['g-recaptcha-response'])){
                $value = $data['g-recaptcha-response'];
            }

            if( !isset($value) || $value==''){
                return  __( 'Tick on captcha', GDFRM_TEXT_DOMAIN ) ;
            }

            $secret_key = \GDForm()->Settings->get( 'RecaptchaSecretKey' );

            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response='.sanitize_text_field( $value );
            $resp = wp_remote_get( esc_url_raw( $url ) );

            if ( !is_wp_error( $resp ) ) {
                $body = wp_remote_retrieve_body( $resp );
                $response = json_decode( $body );
                if ( $response->success === false ) {
                    if ( !empty( $response->{'error-codes'} ) && $response->{'error-codes'} != 'missing-input-response' ) {
                        return  __( 'Please make sure you have entered your Site & Secret keys correctly', GDFRM_TEXT_DOMAIN ) ;
                    }else {
                        return __( 'Captcha mismatch. Please enter the correct value in captcha field', GDFRM_TEXT_DOMAIN ) ;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return false|int
     * @throws \Exception
     */
    public static function delete( $id )
    {
        global $wpdb;

        if ( absint( $id ) != $id ) {

            throw new \Exception( 'Trying to delete a Form with wrong "id" parameter. Parameter "id" must be not negative integer.' );

        }

        $form = $wpdb->get_var( $wpdb->prepare("select Form from ". self::getTableName() ." where Id=%d",$id));

        $wpdb->update(
            Form::getTableName(),
            array(
                'Recaptcha' => NULL,
            ),
            array( 'Id' => $form )
        );

        return $wpdb->query( $wpdb->prepare( "delete from " . self::getTableName() . " where Id =%d", $id ) );
    }

    public function settingsBlock()
    {
        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldNoticeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RecaptchaTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/RecaptchaStyleSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        $recaptchaPublicKey = \GDForm()->Settings->get('RecaptchaPublicKey');
        $recaptchaSecretKey = \GDForm()->Settings->get('RecaptchaSecretKey');

        View::render('frontend/Fields/Recaptcha.php',array(
            'field'=>$this,
            'recaptchaPublicKey'=>$recaptchaPublicKey,
            'recaptchaSecretKey'=>$recaptchaSecretKey
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