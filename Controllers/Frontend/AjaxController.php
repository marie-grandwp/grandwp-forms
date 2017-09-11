<?php

namespace GDForm\Controllers\Frontend;

use GDForm\Models\Form;
use GDForm\Models\Submission;
use GDForm\Models\Fields\Upload;
use GDForm\Models\Fields\Captcha;
use GDForm\Controllers\EmailController;


class AjaxController
{

    public static function init()
    {
        add_action( 'wp_ajax_gdfrm_submit_form', array( __CLASS__, 'submitForm' ) );
        add_action( 'wp_ajax_nopriv_gdfrm_submit_form', array( __CLASS__, 'submitForm' ) );

        add_action( 'wp_ajax_gdfrm_refresh_simple_captcha', array( __CLASS__, 'createSimpleCaptcha' ) );
        add_action( 'wp_ajax_nopriv_gdfrm_refresh_simple_captcha', array( __CLASS__, 'createSimpleCaptcha' ) );
    }


    /**
     ** actions after form is submitted
     **/
    public static function submitForm()
    {
        $form_id = absint($_REQUEST['form_id']);

        $form_data = $_REQUEST['postData'];

        parse_str("$form_data",$form_data);

        $form = new Form( array('Id'=>$form_id) );

        $success = true;

        $validation_errors = $form->validate( $form_data );

        if( !empty($validation_errors) ){
            echo json_encode( array(
                "success"    => false,
                "validation_errors"=>$validation_errors,
            ) );
            die();
        }

        $error = array();

        $attachments = array();

        /* upload submitted files */
        $files_validation_errors = array();
        if( isset($_FILES) && !empty($_FILES) ) {
            foreach ($_FILES as $field => $files) {
                $types = $files['type'];
                $sizes = $files['size'];
                $tmp_names = $files['tmp_name'];
                $errors = $files['error'];

                foreach ($files['name'] as $key=>$filename){
                    $attachment = array();
                    $attachment['name'] = $filename;
                    $attachment['type'] = $types[$key];
                    $attachment['tmp_name'] = $tmp_names[$key];
                    $attachment['size'] = $sizes[$key];
                    $attachment['error'] = $errors[$key];

                    $field_obj = new Upload(str_replace('field-','',$field));

                    $validated = $field_obj->validate($attachment);

                    if( $validated === true ){
                        $overrides = array('test_form' => false);

                        $file = wp_handle_upload($attachment, $overrides);

                        if($file){
                            $attachment['url'] = $file['url'];
                            $attachments[$field][]=$attachment;
                        }
                    } else {
                        $success = false;
                        $files_validation_errors[] = $validated;
                    }


                }
            }
        }

        if( !empty($files_validation_errors) ){
            echo json_encode( array(
                "success"    => false,
                "validation_errors"=>$files_validation_errors,
            ) );
            die();
        }

        $submission = new Submission();

        $submission   -> setForm( $form_id )
            -> setIpAddress( $_SERVER['REMOTE_ADDR'] )
            -> setFields( $form_data )
            -> setAttachments($attachments);

        /* save submissions to database if checked */
        if( $form->getSaveSubmissions() && !empty( $form_data )){
            $submission_id = $submission->save();

            if( !$submission_id ){
                $success = false;
                $error[] = 'Submission was not saved';
            }
        }

        function GdfrmSetContentType ($content_type){
            return 'text/html';
        }

        /* send email to admin */
        if ($form->getEmailAdmin()) {
            add_filter( 'wp_mail_content_type',  array( __CLASS__, 'setMailContentType' ) );

            $mail_sent = EmailController::send(array(
                'recipient' =>'admin',
                'to_mail'   => $form->getAdminEmail(),
                'from_name' => $form->getFromName(),
                'from_email'=> EmailController::$UserEmail,
                'subject'   => $form->getAdminSubject(),
                'message'   => $form->getAdminMessage(),
            ), $form, $submission);

            if (isset($mail_sent['errors'])) {
                $success = false;
                $error[] = $mail_sent['errors'];
            }
        }

        /* send email to user */
        if ( $form->getEmailUsers() && EmailController::$UserEmail) {
            add_filter( 'wp_mail_content_type',  array( __CLASS__, 'setMailContentType' ) );
            $mail_sent = EmailController::send(array(
                'recipient' =>  'user',
                'to_mail'   =>  EmailController::$UserEmail,
                'from_name' =>  $form->getFromName(),
                'from_email'=>  $form->getFromEmail(),
                'subject'   =>  $form->getUserSubject(),
                'message'   =>  $form->getUserMessage(),
            ), $form , $submission);

            if (isset($mail_sent['errors'])) {
                $success = false;
                $error[] = $mail_sent['errors'];
            }
        }


        if ($success) {
            $success_message = ($form->getSuccessMessage()) ? $form->getSuccessMessage() : 'Thank You For Contacting Us';
            echo json_encode(array(
                "success" => 1,
                "action_onsubmit" => $form->getActionOnsubmit()->getId(),
                "success_message" => $success_message,
                "hide_form" => $form->getHideFormOnsubmit(),
                "redirect_url" => $form->getRedirectUrl(),
            ));
            die();
        } else {
            wp_die(implode(', ',$error));
        }
    }

    public static function createSimpleCaptcha()
    {
        return Captcha::createSimpleCaptcha();
    }

    public static function setMailContentType( $content_type )
    {
            return 'text/html';
    }

}