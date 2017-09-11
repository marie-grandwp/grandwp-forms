<?php

namespace GDForm\Models;

use GDForm\Core\Model;

class FieldType extends Model
{

    protected static $tableName = 'GDFormFieldTypes';

    /**
     * Field Type Name
     *
     * @var string
     */
    private $Name;

    /**
     * Field Type is Free or Pro
     *
     * @var int 1|0
     */
    private $IsFree;

    protected static $dbFields = array('Name','IsFree');

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (!empty($this->Name) ? $this->Name : __('(no title)', GDFRM_TEXT_DOMAIN));
    }

    /**
     * @param string $Name
     *
     * @return FieldType
     */
    public function setName($Name)
    {
        $this->Name = sanitize_text_field($Name);

        return $this;
    }

    /**
     * @return string
     */
    public function getIsFree()
    {
        return $this->IsFree;
    }

    /**
     * @param int $value
     *
     * @return FieldType
     */
    public function setIsFree($value)
    {
        $this->IsFree = intval($value);

        return $this;
    }

}