<?php

namespace GDForm\Models;


use GDForm\Core\Model;

class LabelPosition extends Model
{

    protected static $tableName='GDFormLabelPositions';

    protected static $dbFields = array('Name');

    /**
     * Label Position Name
     *
     * @var string
     */
    private $Name;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function getName() {
        return (!empty($this->Name) ? $this->Name : __( '(no title)', GDFRM_TEXT_DOMAIN ) );
    }

    /**
     * @param string $name
     *
     * @return LabelPosition
     */
    public function setName( $name ) {
        $this->Name = sanitize_text_field( $name );

        return $this;
    }

}