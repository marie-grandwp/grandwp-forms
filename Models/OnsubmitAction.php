<?php
namespace GDForm\Models;

use GDForm\Core\Model;

class OnsubmitAction extends Model
{

    protected static $tableName='GDFormOnsubmitActions';

    protected static $dbFields = array('Name');

    /**
     * Onsubmit Action Name
     *
     * @var string
     */
    private $Name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param int $id
     * @return OnsubmitAction
     * @throws \Exception
     */
    public function setId( $id )
    {
        if( absint($id) != $id) {

            throw new \Exception( 'Wrong value for onsubmit action. Value must be int non negative' );

        } else {

            $this->Id= $id;

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (!empty($this->Name) ? $this->Name : __( '(no title)', GDFRM_TEXT_DOMAIN ) );
    }

    /**
     * @param string $name
     *
     * @return OnsubmitAction
     */
    public function setName( $name )
    {
        $this->Name = sanitize_text_field( $name );

        return $this;
    }
}