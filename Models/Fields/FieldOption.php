<?php

namespace GDForm\Models\Fields;

use GDForm\Core\Model;

class FieldOption extends Model
{

    protected static $tableName = 'GDFormFieldOptions';

    protected static $dbFields = array(
        'Name',
        'Value',
        'Field',
        'Checked',
        'Ordering',
        'Image',
    );

    /**
     * Option ID
     *
     * @var int
     */
    protected $Id;

    /**
     * Option Name
     *
     * @var string
     */
    private $Name;

    /**
     * Option Value
     *
     * @var string
     */
    private $Value;

    /**
     * Option Field ID
     *
     * @var int
     */
    private $Field;

    /**
     * Option checked
     *
     * @var int 0,1
     */
    private $Checked;

    /**
     * Option order
     *
     * @var int
     */
    private $Ordering;

    /**
     * Option image
     *
     * @var string
     */
    private $Image;

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
     * @param string $name
     *
     * @return FieldOption
     */
    public function setName($name)
    {

        $this->Name = sanitize_text_field($name);

        return $this;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return intval($this->Ordering);
    }

    /**
     * @param int $order
     *
     * @return FieldOption
     */
    public function setOrdering($order)
    {
        if (absint($order) == $order) $this->Ordering = intval($order);

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param string $value
     *
     * @return FieldOption
     */
    public function setValue($value)
    {
        $this->Value = sanitize_text_field($value);

        return $this;
    }

    /**
     * @return int
     */
    public function getField()
    {

        return $this->Field;

    }

    /**
     * @param int $field
     *
     * @return FieldOption
     */
    public function setField($field)
    {

        $this->Field = $field;

        return $this;
    }

    /**
     * @return int 0,1
     */
    public function getChecked()
    {

        return $this->Checked;

    }

    /**
     * @param string $value
     *
     * @return FieldOption
     */
    public function setChecked($value)
    {
        if (in_array($value, array(0, 1, 'on'))) {

            if ($value == 'on') $value = 1;
            $this->Checked = intval($value);

        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param string $image
     *
     * @return FieldOption
     */
    public function setImage($image)
    {
        $this->Image = $image;

        return $this;
    }

    /**
     * unset option id
     */
    public function unsetId()
    {
        $this->Id = null;

        return $this;
    }

    public function optionRow()
    {

        if ($this->getImage()) {
            $html = '<div class="option option-image" data-option-id="' . $this->Id . '"><div class="one-fifth"><i class="fa fa-trash-o gdfrm-remove-option" aria-hidden="true" data-option="' . $this->Id . '"></i><img src="' . $this->getImage() . '"><input type="hidden" name="option_image-' . $this->Id . '" value="' . $this->getImage() . '" ><input type="hidden" class="setting-option-order" name="order-option-' . $this->Id . '" value="' . $this->Ordering . '"></div>';
            $html .= '<div class="four-fifth"><div class="gdfrm-fullwidth"><label class="gdfrm-fullwidth" for="optionName-' . $this->Id . '">Option Name</label><input type="text" class="checkbox-option" name="optionName-' . $this->Id . '" placeholder="Option Name" value="' . $this->Name . '"></div>';
            $html .= '<div class="gdfrm-fullwidth"><label class="gdfrm-fullwidth" for="optionValue-' . $this->Id . '">Option Value</label><input type="text" class="checkbox-option" placeholder="Option Value" name="optionValue-' . $this->Id . '" value="' . $this->Value . '"></div>';
            $html .= '</div></div>';

        } else {
            $html = '<div class="option" data-option-id="' . $this->Id . '">';
            $fieldObj = Field::get(array('Id'=>$this->Field));
            if($fieldObj->getType()->getName()=='checkbox')$html .= '<input type="checkbox" ' . checked(1, $this->Checked, false) . ' name="checked-' . $this->Id . '">';
            $html .= '<input type="hidden" class="setting-option-order" name="order-option-' . $this->Id . '" value="' . $this->Ordering . '">';
            $html .= '<input type="text" class="checkbox-option" name="optionName-' . $this->Id . '" placeholder="Option Name" value="' . $this->Name . '">';
            $html .= '<input type="text" class="checkbox-option" placeholder="Option Value" name="optionValue-' . $this->Id . '" value="' . $this->Value . '">';
            $html .= '<i class="fa fa-trash-o gdfrm-remove-option" aria-hidden="true" data-option="' . $this->Id . '"></i></div>';

        }


        return $html;
    }

    public function setProperties($fields_settings)
    {

        $this ->setName($fields_settings['optionName-' . $this->Id . ''])
              ->setOrdering($fields_settings['order-option-' . $this->Id . ''])
              ->setImage($fields_settings['option_image-' . $this->Id . ''])
              ->setChecked($fields_settings['checked-' . $this->Id . ''])
              ->setValue($fields_settings['optionValue-' . $this->Id . '']);


    }

}