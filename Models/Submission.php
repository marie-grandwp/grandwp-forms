<?php

namespace GDForm\Models;

use GDForm\Core\Model;
use GDForm\Models\Fields\Field;

class Submission extends Model
{

    protected static $tableName='GDFormSubmissions';
    protected static $DataTableName='GDFormSubmissionFields';


    protected static $dbFields = array('Date','Form','IpAddress','Viewed','Spam','Submission');

    /**
     * Submission Fields
     *
     * @var array
     */
    private $Fields;

    /**
     * Submission File Attachments
     *
     * @var array
     */
    private $Attachments;


    /**
     * Submission date
     *
     * @var string date
     */
    private $Date;

    /**
     * Submission form
     *
     * @var int $form
     */
    private $Form;

    /**
     * Submission ip address
     *
     * @var int $ip_address
     */
    private $IpAddress;

    /**
     * Submission viewed
     *
     * @var int 0|1
     */
    private $Viewed;

    /**
     * Submission marked as spam
     *
     * @var int 0|1
     */
    private $Spam;

    /**
     * Submission data
     * Array of field values for current Submission
     *
     * @var array
     */
    private $Submission;

    /**
     * @var Form
     */
    private $FormObject;


    public function __construct(array $args = array())
    {
        parent::__construct($args);

        global $wpdb;

        if(null!==$this->Id){
            $submission_data = $wpdb->get_results( $wpdb->prepare(
                " SELECT * FROM " . static::getDataTableName() . " WHERE Submission=%d",
                $this->Id
            ), ARRAY_A );

            $this->setSubmission($submission_data);
        }
    }

    protected static function getDataTableName()
    {
        return $GLOBALS['wpdb']->prefix.static::$DataTableName;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return array
     */
    public function getSubmissionFields()
    {
        return $this->Submission;
    }

    /**
     * @param array $submission
     *
     * @return Submission
     */
    public function setSubmission( $submission )
    {
        $submission_array = array();
        foreach ( $submission as $single_submission ){
            $submission_array[] = array(
                'Id'=>$single_submission['Id'],
                'Field'=>Field::get(array('Id'=>$single_submission['Field'])),
                'Value'=>$single_submission['Value']
            );
        }

        $this->Submission = $submission_array;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param string $date
     *
     * @return Submission
     */
    public function setDate( $date )
    {

        $this->Date =  $date;


        return $this;
    }

    /**
     * @return int
     */
    public function getForm()
    {
        return $this->Form;
    }

    /**
     * @param int $form
     *
     * @return Submission
     */
    public function setForm( $form )
    {

        if( absint($form) == $form ){

            $this->Form =  $form ;

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getIpAddress()
    {
        return $this->IpAddress;
    }

    /**
     * @param $value
     * @return Submission
     *
     */
    public function setIpAddress( $value )
    {

        $this->IpAddress =  $value ;

        return $this;
    }

    /**
     * @return int
     */
    public function getViewed()
    {
        return $this->Viewed;
    }

    /**
     * @param int $value
     *
     * @return Submission
     */
    public function setViewed( $value )
    {

        if(in_array($value,array(0,1))){

            $this->Viewed = $value;

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getSpam()
    {
        return $this->Spam;
    }

    /**
     * @param int $value
     *
     * @return Submission
     */
    public function setSpam( $value )
    {

        if(in_array($value,array(0,1))){

            $this->Spam = $value;

        }

        return $this;
    }
    /**
     *
     * @return array $fields
     */
    public function getFields( )
    {

        return $this->Fields;
    }

    /**
     * @param array $fields
     *
     * @return Submission
     */
    public function setFields( $fields )
    {
        if( is_array( $fields ) ) {
            $this->Fields =  $fields;
        }

        return $this;
    }

    /**
     *
     * @return array $attachments
     */
    public function getAttachments( )
    {

        return $this->Attachments;
    }

    /**
     * @param array $attachments
     *
     * @return Submission
     */
    public function setAttachments( $attachments )
    {
        if( is_array( $attachments ) ) {
            $this->Attachments =  $attachments;
        }

        return $this;
    }

    public function getFormObject()
    {
        if(null!==$this->FormObject){
            return $this->FormObject;
        }

        $this->FormObject = new Form(array('Id'=>$this->Form));
        return $this->FormObject;

    }

    public function save($Id = null)
    {
        $saved =  parent::save($Id);

        if(false !== $saved){
            global $wpdb;

            if($this->Fields):
                foreach ($this->Fields as $key=>$value){
                    $submission_field_row = array();

                    if (strpos($key, 'field-') !== false) {
                        $submission_field = str_replace('field-','',$key);

                        if(is_array($value)){ $submission = json_encode($value);}
                        else{ $submission = $value; }

                        $submission_field_row['Submission'] = $this->Id;
                        $submission_field_row['Field'] = $submission_field;
                        $submission_field_row['Value'] = $submission;

                        $wpdb->insert( static::getDataTableName(), $submission_field_row );
                    }
                }
            endif;

            if($this->Attachments):
                foreach ($this->Attachments as $key=>$attachment){

                    $attachment_field_row = str_replace('field-','',$key);
                    $submission = json_encode($attachment);

                    $submission_field_row['Submission'] = $this->Id;
                    $submission_field_row['Field'] = $attachment_field_row;
                    $submission_field_row['Value'] = $submission;

                    $wpdb->insert( static::getDataTableName(), $submission_field_row );

                }
            endif;
        }

        return $wpdb->insert_id;

    }
}