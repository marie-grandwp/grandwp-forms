<?php

namespace GDForm\Models;

use GDForm\Core\Model;
use GDForm\Models\Fields\Field;

class Form extends Model
{

    protected static $tableName = 'GDFormForms';

    /**
     * Form Name
     *
     * @var string
     */
    private $Name;

    /**
     * Fields of current form
     * Array of Field instances
     *
     * @var Field[]
     */
    private $Fields;

    /**
     * Theme of current form
     *
     * @var Theme
     */
    private $Theme;

    /**
     * @var int
     */
    private $ThemeId;

    /**
     * show form title
     *
     * @var int
     */
    private $DisplayTitle;

    /**
     * hide form on submit
     *
     * @var int
     */
    private $HideFormOnsubmit;

    /**
     * action on submit
     *
     * @var OnsubmitAction
     */
    private $ActionOnsubmit;

    /**
     * action on submit
     *
     * @var int
     */
    private $ActionOnsubmitId;

    /**
     * success message
     *
     * @var string
     */
    private $SuccessMessage;

    /**
     * redirect after submitting the form
     *
     * @var string
     */
    private $RedirectUrl;

    /**
     * save submissions to database
     *
     * @var int 0|1
     */
    private $SaveSubmissions;

    /**
     * admin email
     *
     * @var string
     */
    private $AdminEmail;

    /**
     * user email
     *
     * @var string
     */
    private $UserEmail;

    /**
     * admin subject
     *
     * @var string
     */
    private $AdminSubject;

    /**
     * admin message
     *
     * @var string
     */
    private $AdminMessage;

    /**
     * user mail subject
     *
     * @var string
     */
    private $UserSubject;

    /**
     * user mail message
     *
     * @var string
     */
    private $UserMessage;

    /**
     * Emails are Sent from this Name
     *
     * @var string
     */
    private $FromName;

    /**
     * Emails are Sent from this Email
     *
     * @var string
     */
    private $FromEmail;

    /**
     * send email to users
     *
     * @var int 0,1
     */
    private $EmailUsers;

    /**
     * send email to admin
     *
     * @var int 0,1
     */
    private $EmailAdmin;

    /**
     * labels position
     *
     * @var LabelPosition
     */
    private $LabelsPosition;

    /**
     * @var int
     */
    private $LabelsPositionId;

    /**
     * email format wrong error message
     *
     * @var string
     */
    private $EmailFormatError;

    /**
     * required field empty error message
     *
     * @var string
     */
    private $RequiredEmptyError;

    /**
     * upload size exceeded error message
     *
     * @var string
     */
    private $UploadSizeError;

    /**
     * upload file format error message
     *
     * @var string
     */
    private $UploadFormatError;

    /**
     * whether form has hidden|regular or no recaptcha, default NULL
     *
     * @var string
     */
    private $Recaptcha;

    /**
     * save submissions to database
     *
     * @var int 0|1
     */
    private $SubmitNoticeShown;

    /**
     * form is preview or active
     *
     * @var int
     */
    private $IsPreview;

    protected static $dbFields = array(
        'Name', 'ThemeId', 'DisplayTitle', 'HideFormOnsubmit', 'ActionOnsubmitId', 'SuccessMessage', 'RedirectUrl', 'SaveSubmissions',
        'AdminEmail', 'UserEmail', 'AdminSubject', 'UserSubject', 'AdminMessage', 'UserMessage', 'FromName', 'FromEmail', 'EmailAdmin', 'EmailUsers',
        'LabelsPositionId', 'EmailFormatError', 'RequiredEmptyError', 'UploadSizeError', 'UploadFormatError','SubmitNoticeShown','IsPreview'
    );


    public function __construct( $args = array() )
    {
        parent::__construct($args);

        if (null !== $this->Id) {
            $this->Fields = $this->getFields();
        } else {
            $this->Name = __('New Form', GDFRM_TEXT_DOMAIN);

            $this->DisplayTitle = 1;
        }

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     *
     */
    public function unsetId()
    {
        $this->Id = null;

        return $this;
    }

    /**
     * When cloning an instance of Field id and form are changed to be null in order to have a clear copy of this field
     */
    public function __clone()
    {
        $this->unsetId();

        if(!empty($this->Fields)){
            foreach ($this->Fields as $field){

            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (!empty($this->Name) ? $this->Name : __('(no title)', GDFRM_TEXT_DOMAIN));
    }

    /**
     * @param string $name
     *
     * @return Form
     */
    public function setName($name)
    {
        $this->Name = sanitize_text_field($name);

        return $this;
    }

    /**
     * Edit link for current form
     */
    public function getEditLink()
    {

        if (is_null($this->Id)) {
            return false;
        }

        return admin_url('admin.php?page=gdfrm&task=edit_form&id=' . $this->Id);

    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        if (empty($this->Fields)) {
            global $wpdb;

            $query = $wpdb->prepare("select * from " . Field::getTableName() . " where Form=%d order by Ordering", $this->Id);

            $fields = $wpdb->get_results($query);

            if (empty($fields)) {
                return null;
            }

            $fieldsArray = array();

            foreach ($fields as $field) {
                $fieldsArray[] = Field::get(array('Id'=>$field->Id));
            }

            $this->Fields = $fieldsArray;
        }
        return $this->Fields;
    }

    /**
     * @param Field[] $fields
     *
     * @return Form
     * @throws \Exception
     */
    public function setFields($fields)
    {
        foreach ($fields as $field) {
            if (!($field instanceof Field)) {
                throw new \Exception('Field must be an instance of Field class.');
            }

        }

        $this->Fields = $fields;

        return $this;
    }

    /**
     * return string 0|1
     */
    public function getDisplayTitle()
    {
        return $this->DisplayTitle;
    }

    /**
     * @param $value int 0,1
     * @return $this
     */
    public function setDisplayTitle($value)
    {
        if (in_array($value, array(0, 1,'on'))) {
            if($value == 'on') $value=1;

            $this->DisplayTitle = intval($value);
        }
        return $this;
    }

    /**
     * return string 0|1
     */
    public function getRecaptcha()
    {
        return $this->Recaptcha;
    }

    /**
     * @param $value int 0,1
     * @return $this
     * @throws \Exception
     */
    public function setRecaptcha($value)
    {
        if (!in_array($value, array('hidden', 'regular', 0))) {
            throw new \Exception('Wrong value for show title. Value must be int 0|1');
        }

        $this->Recaptcha = $value;

        return $this;
    }

    /**
     * return OnsubmitAction
     */
    public function getActionOnsubmit()
    {

        return $this->ActionOnsubmit;

    }

    /**
     * @param $value int
     * return Form
     * @return $this
     * @throws \Exception
     */
    public function setActionOnsubmit($value)
    {
        if (absint($value) != $value) {

            throw new \Exception('Wrong value for onsubmit action. Value must be int non negative');

        } else {

            $this->ActionOnsubmitId = absint($value);

            $this->ActionOnsubmit = new OnsubmitAction(array('Id' => $value));

        }

        return $this;
    }

    /**
     * return int
     */
    public function getActionOnsubmitId()
    {

        return $this->ActionOnsubmitId;

    }

    /**
     * @param $value int
     * return Form
     * @return $this
     * @throws \Exception
     */
    public function setActionOnsubmitId($value)
    {
        return $this->setActionOnsubmit($value);
    }

    /**
     * return string
     */
    public function getSuccessMessage()
    {
        return ($this->SuccessMessage)?wp_unslash($this->SuccessMessage):'Thank You For Contacting Us';
    }

    /**
     * @param $value string
     * @return $this
     * @throws \Exception
     */
    public function setSuccessMessage($value)
    {

        $this->SuccessMessage = $value;

        return $this;
    }

    /**
     * return string 0|1
     */
    public function getHideFormOnsubmit()
    {
        return $this->HideFormOnsubmit;
    }

    /**
     * @param $value int 0,1
     * @return Form
     */
    public function setHideFormOnsubmit($value)
    {
        if (in_array($value, array(0, 1,'on'))) {
            if ($value == 'on') $value = 1;
            $this->HideFormOnsubmit = intval($value);
        }
        return $this;
    }


    /**
     * return string 0|1
     */
    public function getSubmitNoticeShown()
    {
        return $this->SubmitNoticeShown;
    }

    /**
     * @param $value int 0,1
     * @return Form
     */
    public function setSubmitNoticeShown($value)
    {
        if (in_array($value, array(0, 1,'on'))) {
            if ($value == 'on') $value = 1;
            $this->SubmitNoticeShown = intval($value);
        }
        return $this;
    }

    /**
     * return string
     */
    public function getRedirectUrl()
    {
        return $this->RedirectUrl;
    }

    /**
     * @param $value string
     * @return Form
     * @throws \Exception
     */
    public function setRedirectUrl($value)
    {

        $this->RedirectUrl = sanitize_text_field($value);

        return $this;
    }

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->Theme;
    }

    /**
     * @param $id int
     * @return Form
     * @throws \Exception
     */
    public function setTheme($id)
    {
        if(empty($id)){
            return $this;
        }

        if (absint($id) == $id) {
            $this->ThemeId = absint($id);
            $this->Theme = new Theme(array('Id' => $this->ThemeId));
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getThemeId()
    {
        return $this->ThemeId;
    }

    /**
     * @param $ThemeId int
     * @return Form
     */
    public function setThemeId($ThemeId)
    {
        return $this->setTheme($ThemeId);
    }

    /**
     * return string
     */
    public function getEmailUsers()
    {
        return $this->EmailUsers;
    }

    /**
     * @param $value int
     * @return $this
     */
    public function setEmailUsers($value)
    {
        if (in_array($value, array(0, 1, 'on'))) {
            if ($value == 'on') $value = 1;
            $this->EmailUsers = intval($value);
        }

        return $this;
    }

    /**
     * return string
     */
    public function getEmailAdmin()
    {
        return $this->EmailAdmin;
    }

    /**
     * @param $value int
     * @return $this
     */
    public function setEmailAdmin($value)
    {
        if (in_array($value, array(0, 1, 'on'))) {
            if ($value == 'on') $value = 1;
            $this->EmailAdmin = intval($value);
        }

        return $this;
    }

    /**
     * return int
     */
    public function getSaveSubmissions()
    {
        return $this->SaveSubmissions;
    }

    /**
     * @param $value int
     * @return $this
     */
    public function setSaveSubmissions($value)
    {
        if (in_array($value, array(0, 1, 'on'))) {
            if ($value == 'on') $value = 1;
            $this->SaveSubmissions = intval($value);
        }
        return $this;
    }

    /**
     * return string
     */
    public function getFromName()
    {
        return $this->FromName;
    }

    /**
     * @param $value string
     * @return $this
     */
    public function setFromName($value)
    {

        $this->FromName = sanitize_text_field($value);

        return $this;
    }

    /**
     * return string
     */
    public function getFromEmail()
    {
        return $this->FromEmail;
    }

    /**
     * @param $email string
     * @return $this
     */
    public function setFromEmail($email)
    {

        $this->FromEmail = sanitize_email($email);

        return $this;
    }

    /**
     * return string
     */
    public function getAdminEmail()
    {
        return ($this->AdminEmail)?$this->AdminEmail:get_option('admin_email');
    }

    /**
     * @param $email string
     * @return $this
     */
    public function setAdminEmail($email)
    {
        $this->AdminEmail = sanitize_email($email);

        return $this;
    }

    /**
     * return string
     */
    public function getUserEmail()
    {
        return $this->UserEmail;
    }

    /**
     * @param $email string
     * @return $this
     */
    public function setUserEmail($email)
    {
        $this->UserEmail = sanitize_email($email);

        return $this;
    }

    /**
     * return string
     */
    public function getAdminSubject()
    {
        return $this->AdminSubject;
    }

    /**
     * @param $subject string
     * @return $this
     */
    public function setAdminSubject($subject)
    {

        $this->AdminSubject = sanitize_text_field($subject);

        return $this;
    }

    /**
     * return string
     */
    public function getAdminMessage()
    {
        return ($this->AdminMessage)?wp_unslash($this->AdminMessage):'Form Was Submitted on Your Website. [formData]';
    }

    /**
     * @param $message string
     * @return $this
     */
    public function setAdminMessage($message)
    {
        $this->AdminMessage = wp_kses_post($message);

        return $this;
    }

    /**
     * return string
     */
    public function getUserSubject()
    {
        return $this->UserSubject;
    }

    /**
     * @param $subject string
     * @return $this
     */
    public function setUserSubject($subject)
    {

        $this->UserSubject = sanitize_text_field($subject);

        return $this;
    }

    /**
     * return string
     */
    public function getUserMessage()
    {
        return ($this->UserMessage)?wp_unslash($this->UserMessage):'Thank You For Your Submission. We will get back to you as soon as possible.';
    }

    /**
     * @param $message string
     * @return $this
     */
    public function setUserMessage($message)
    {
        $this->UserMessage = wp_kses_post($message);

        return $this;
    }

    /**
     * @return LabelPosition
     */
    public function getLabelsPosition()
    {
        return $this->LabelsPosition;
    }

    /**
     * @param $position int
     * @return $this
     */
    public function setLabelsPosition($position)
    {

        if (absint($position) == $position) {

            $this->LabelsPositionId = absint($position);

            $this->LabelsPosition = new LabelPosition(array('Id'=>$position));

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getLabelsPositionId()
    {
        return $this->LabelsPositionId;
    }

    /**
     * @param $PositionId int
     * @return Form
     */
    public function setLabelsPositionId($PositionId)
    {
        return $this->setLabelsPosition($PositionId);
    }

    /**
     * return string
     */
    public function getEmailFormatError()
    {
        return ($this->EmailFormatError)?wp_unslash($this->EmailFormatError):'Wrong Email Format';
    }

    /**
     * @param $email_format_error
     * @return Form
     */
    public function setEmailFormatError($email_format_error)
    {

        $this->EmailFormatError = sanitize_text_field($email_format_error);

        return $this;
    }

    /**
     * return string
     */
    public function getRequiredEmptyError()
    {
        return ($this->RequiredEmptyError)?wp_unslash($this->RequiredEmptyError):'This field is required';
    }

    /**
     * @param $required_error string
     * @return Form
     */
    public function setRequiredEmptyError($required_error)
    {

        $this->RequiredEmptyError = sanitize_text_field($required_error);

        return $this;
    }

    /**
     * return string
     */
    public function getUploadSizeError()
    {
        return ($this->UploadSizeError)?wp_unslash($this->UploadSizeError):'Max Upload Size Exceeded';
    }

    /**
     * @param $upload_size_error string
     * @return Form
     */
    public function setUploadSizeError($upload_size_error)
    {

        $this->UploadSizeError = sanitize_text_field($upload_size_error);

        return $this;
    }

    /**
     * return string
     */
    public function getUploadFormatError()
    {
        return ($this->UploadFormatError)?wp_unslash($this->UploadFormatError):'Wrong File Format';
    }

    /**
     * @param $upload_format_error string
     * @return Form
     */
    public function setUploadFormatError($upload_format_error)
    {

        $this->UploadFormatError = sanitize_text_field($upload_format_error);

        return $this;
    }

    /**
     * @return int
     */
    public function getIsPreview()
    {
        return $this->IsPreview;
    }

    /**
     * @param $ThemeId int
     * @return Form
     */
    public function setIsPreview($value)
    {
        if(in_array($value,array(0,1))) $this->IsPreview=$value;

        return $this;
    }


    public function validate($data)
    {
        $errors = array();
        $fields = $this->Fields;

        foreach ($fields as $field) {

            if ($field && method_exists($field, 'validate')) {
                $validation_passed = $field->validate($data);

                if ($validation_passed !== true) {
                    $errors[] = array(
                        'field' => $field->getId(),
                        'error' => $validation_passed
                    );
                }
            }

        }

        return $errors;
    }


    public function getField($FieldId)
    {
        if (empty($this->Fields)) {
            return null;
        }

        foreach ($this->Fields as $field) {
            if ($field->getId() == $FieldId) {
                return $field;
            }
        }
    }

    /**
     * @param null $Id
     * @return bool
     */
    public function save($Id = null)
    {
        global $wpdb;

        $key = static::$primaryKey;

        $data = $this->prepareSaveData( $Id );

        if ( null === $this->$key ) {
            $result = $wpdb->insert(static::getTableName(), $data);

            $formId = $wpdb->insert_id;

            if(!empty($this->Fields)){
                foreach ($this->Fields as $field){
                    $field -> setForm( $formId ) -> save();
                }
            }
        } else {
            $result = $wpdb->update(static::getTableName(), $data, array($key => $this->$key));
            $formId = $this->$key;
        }

        if(false !== $result){
            if(null === $this->$key) {
                $this->$key = $formId;
            }
            return $this->$key;
        }

        return false;
    }

    /**
     * @return int
     */
    public static function getAllItemsCount(){
        if (null === static::$AllItemsCount) {
            global $wpdb;
            static::$AllItemsCount = $wpdb->get_var("select count(*) from " . static::getTableName() . " WHERE IsPreview = 0");
        }

        return static::$AllItemsCount;
    }

    public static function deletePreviewForms()
    {
        global $wpdb;

        $wpdb->delete(static::getTableName(), array('IsPreview'=>1));

        return 'br';
    }
}