<?php

namespace GDForm\Controllers;

use GDForm\Models\Fields;
use GDForm\Models\Submission;

class EmailController
{

    /**
     * email of user
     *
     * @var string
     */
    public static $UserEmail;

    /**
     * send email to
     *
     * @var string
     */
    public static $to;

    /**
     * send mail from email
     *
     * @var string
     */
    public static $FromEmail;

    /**
     * send mail from name
     *
     * @var string
     */
    public static $FromName;

    /**
     * mail subject
     *
     * @var string
     */
    public static $subject;

    /**
     * mail message
     *
     * @var string
     */
    public static $message;

    /**
     * mail attachments
     *
     * @var array
     */
    public static $attachments;

    public static function setProperty($name,$value){
        return self::$$name = $value;
    }

    /**
     * @var $settings array
     * @var $form_id int
     * @var $data array
     * @param $submission Submission
     *
     * @return array
     **/
    public static function send( $settings, $form, $submission )
    {
        $recipient = $settings['recipient'];

        $to = $settings['to_mail'];

        $message = $settings['message'];

        if(strpos($message,'[formData]')!==false){
            $data = '<table>';
            foreach ( $submission->getFields() as $field=>$value ){
                $field_id = str_replace('field-','',$field);

                if(intval($field_id)){
                    $field_obj = Fields\Field::get(array('Id'=>$field_id));

                    if(is_array($value)){
                        foreach ($value as $single_key => $single_value){
                            if(is_numeric($single_key)){
                                $data .= '<tr><td style="border: 1px solid #c9c5c5;padding: 5px;">'.$field_obj->getLabel().' </td><td style="border: 1px solid #c9c5c5;padding: 5px;"> '.implode(',',$value).'</td></tr>';
                                break;
                            } else {
                                $data .= '<tr><td style="border: 1px solid #c9c5c5;padding: 5px;">'.$single_key.' </td><td style="border: 1px solid #c9c5c5;padding: 5px;"> '.$value.'</td></tr>';
                            }
                        }
                    } else {
                        $data .= '<tr><td style="border: 1px solid #c9c5c5;padding: 5px;">'.$field_obj->getLabel().' </td><td style="border: 1px solid #c9c5c5;padding: 5px;"> '.$value.'</td></tr>';
                    }
                }
            }
            $data .= '</table>';
            $message = str_replace('[formData]', $data, $message);
        }

        if( $recipient == 'user' ){
            $from_email = ( $settings['from_email'] == '' ) ? get_option('admin_email'): $settings['from_email'];
            $from_name  = ( $settings['from_name'] == '' ) ? get_option('blogname'): $settings['from_name'];
            $subject    = ( $settings['subject'] == '' ) ? $form->getName(): $settings['subject'];
            $message    = ( $message == '') ? 'Thank You For Your Submission. We will get back to you as soon as possible.': $message;
        } else if( $recipient == 'admin' ){
            if($to=='') $to = get_option('admin_email');
            $from_email = ( $settings['from_email'] == '' ) ? 'submission@gdfrm.com': $settings['from_email'];
            $from_name  = ( $settings['from_name'] == '' ) ? get_option('blogname'): $settings['from_name'];
            $subject    = ( $settings['subject'] == '' ) ? $form->getName(): $settings['subject'];
            $message    = ( $message == '') ? 'Form Was Submitted on Your Website. [formData]': $message;
        }


        $headers = array('From: ' . $from_name . ' <' . $from_email . '>');


        try {
            $sent = wp_mail($to, $subject, $message, $headers);
        } catch ( Exception $e ){
            $sent = false;
            $errors = $e->getMessage();
        }

        $return[ 'email' ][ 'to' ] = $to;
        $return[ 'email' ][ 'sent' ] = $sent;
        $return[ 'email' ][ 'headers' ] = $headers;

        if( isset($errors) ){
            $return[ 'errors' ] = $errors;
        }

        return $return;
    }

}