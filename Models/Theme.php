<?php

namespace GDForm\Models;

use GDForm\Core\Model;

class Theme extends Model
{
    protected static $tableName='GDFormThemes';

    /**
     * Theme Name
     *
     * @var string
     */
    private $Name;

    protected static $dbFields = array('Name');

    /**
     * @return int
     */
    public function getId() {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function getName() {
        return (!empty($this->Name) ? $this->Name : __( '(Empty Theme)', GDFRM_TEXT_DOMAIN ) );
    }

    /**
     * @param string $name
     *
     * @return Theme
     */
    public function setName( $name ) {
        $this->Name = sanitize_text_field( $name );

        return $this;
    }

}