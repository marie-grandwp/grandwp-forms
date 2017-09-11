<?php

namespace GDForm\Models\Fields;

use GDForm\Helpers\View;

class Captcha extends Field
{

    private static $CaptchaTableName = 'GDFormCaptchas';

    public static function getCaptchaTableName()
    {
        return $GLOBALS['wpdb']->prefix.self::$CaptchaTableName;
    }


    public function settingsBlock()
    {
        $settings_block_html='<div class="settings-block" data-field-id="'.$this->Id.'">';
        $settings_block_html .= View::buffer('admin/FieldSettings/FieldTypeSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/LabelPositionSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/PlaceholderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/OrderSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/HelptextSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ClassSettingRow.php', array('field'=>$this));
        $settings_block_html .= View::buffer('admin/FieldSettings/ContainerClassSettingRow.php', array('field'=>$this));
        $settings_block_html.='</div>';

        return $settings_block_html;
    }

    public function fieldHtml()
    {
        View::render('frontend/Fields/Captcha.php', array('field'=>$this));
    }

    public static function createSimpleCaptcha($captcha_id='',$from='')
    {

        $upload_dir=wp_upload_dir();

        if (!file_exists($upload_dir['basedir']."/gdfrm_tmp")) {
            mkdir($upload_dir['basedir']."/gdfrm_tmp", 0777, true);
        }

        $current_dir = getcwd(); // Save the current directory
        $dir = $upload_dir['basedir']."/gdfrm_tmp/";

        chdir($dir);
        /*** cycle through all files in the directory ***/
        foreach (glob($dir."*") as $file) {
            /*** if file is 1/2 hours (1800 seconds) old then delete it ***/
            if (filemtime($file) < time() - 1800) {
                unlink($file);
            }
        }
        chdir($current_dir); // Restore the old working directory

        $is_ajax_request=false;

        if(isset($_POST['captchaid'])){
            $captcha_id = intval($_POST['captchaid']);
            $is_ajax_request=true;
        }


        $time = time();

        $captcha='';

        for($i=1;$i<=5;$i++){
            $randnumber=rand(65,122);
            while(in_array($randnumber,array(91,92,93,94,95,96))){
                $randnumber=rand(65,122);
            }
            $captcha.=chr($randnumber);
        }

        $font_size=28;

        $inserted_id = self::insertNewCaptcha($captcha,$captcha_id);


        $font = GDFRM_FONTS_PATH.'dirty_classic_machine.ttf';
        $image=imagecreatetruecolor(170,62);

        $black=imagecolorallocate($image,90,97,106);
        $white=imagecolorallocate($image,255,255,255);

        imagefilledrectangle($image,0,0,170,62,$white);

        imagettftext($image,$font_size,0,45,45,$black,$font,$captcha);

        $filename='captcha-'.$from.'-'.md5($captcha_id.$time).'.png';

        imagepng($image,$dir.'/'.$filename);

        if($is_ajax_request){
            wp_send_json(array(
                'url'=>$upload_dir['baseurl']."/gdfrm_tmp/".$filename,
                'id'=>$inserted_id
            ));
        }

        $return['url'] = $upload_dir['baseurl']."/gdfrm_tmp/".$filename;
        $return['id']  = $inserted_id;

        return $return;

    }

    /* validate captcha field */
    public function validate( $data ) {
        if( isset($data['field-'.$this->Id]) &&  isset($data['captcha-id']) ){
            $code = self::getCode($data['captcha-id']);
            if($code != $data['field-'.$this->Id]){
                return 'Please refresh the code and try again';
            }
        }

        return true;
    }

    /**
     * @param $captcha
     * @param $field
     * @return bool|int
     */
    public static function insertNewCaptcha($captcha,$field)
    {
        global $wpdb;

        $success = $wpdb->insert( self::getCaptchaTableName() ,
            array(
                'Captcha' => esc_sql($captcha),
                'Field' => esc_sql($field)
            )
        );

        if($success){
            return $wpdb->insert_id;
        } else{
            return false;
        }
    }

    /**
     * @param $id int
     * @return null|string
     */
    public static function getCode($id)
    {
        global $wpdb;

        $id = intval( $id );
        $code = $wpdb->get_var('SELECT `Captcha` FROM '.self::getCaptchaTableName().' WHERE `Id`= '.$id);

        return $code;
    }

    public static function cleanOldCaptchas()
    {
        global $wpdb;

        $d = date('Y-m-d h:i:s',time()-2 * 24 * 60 * 60);

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM ".self::getCaptchaTableName()." WHERE Created<=%s ",$d)
        );
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