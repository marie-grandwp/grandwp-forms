<?php

namespace GDForm\Models\Fields;

use GDForm\Core\Model;
use GDForm\Models\FieldType;
use GDForm\Models\Form;

abstract class Field extends Model
{

    protected static $tableName = 'GDFormFields';

    protected static $dbFields = array(
        'Label',
        'LabelPosition',
        'DefaultValue',
        'Class',
        'ContainerClass',
        'Placeholder',
        'HelperText',
        'Required',
        'Disabled',
        'Form',
        'Ordering',
        'TypeId'
    );

    /**
     * Field Label
     *
     * @var string
     */
    protected $Label;

    /**
     * Field Order
     *
     * @var int
     */
    protected $Ordering;

    /**
     * Field Label Position
     *
     * @var int
     */
    protected $LabelPosition;

    /**
     * Field Default Value
     *
     * @var string
     */
    protected $DefaultValue;

    /**
     * Field Class
     *
     * @var string
     */
    protected $Class;

    /**
     * Field Container Class
     *
     * @var string
     */
    protected $ContainerClass;

    /**
     * Field Placeholder
     *
     * @var string
     */
    protected $Placeholder;

    /**
     * Field Help Text
     *
     * @var string
     */
    protected $HelperText;

    /**
     * Field is required
     *
     * @var int(0,1)
     */
    protected $Required = 0;

    /**
     * Field is disabled
     *
     * @var int(0,1)
     */
    protected $Disabled = 0;

    /**
     * Field Form
     *
     * @var int
     */
    protected $Form;

    /**
     * @var Form
     */
    protected $FormObject;

    /**
     * Field Type
     *
     * @var FieldType
     */
    protected $Type;

    /**
     * @var int
     */
    protected $TypeId;

    /**
     * When cloning an instance of Field id and form are changed to be null in order to have a clear copy of this field
     */
    public function __clone()
    {
        $this->Id = null;
        $this->Form = null;
    }

    public function unsetId()
    {
        $this->Id = null;

        return $this;
    }

    /**
     * @param $Id
     *
     * @return false|int
     * @throws \Exception
     */
    public static function delete($Id)
    {
        global $wpdb;

        if (absint($Id) != $Id) {

            throw new \Exception('Parameter "Id" must be non negative integer.');

        }

        $field_type = $wpdb->get_var($wpdb->prepare("select TypeId from " . self::getTableName() . " where Id=%d", $Id));

        if ($field_type == 9) {
            return Recaptcha::delete($Id);
        } else {
            return $wpdb->query($wpdb->prepare("delete from " . self::getTableName() . " where Id =%d", $Id));
        }

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return wp_unslash($this->DefaultValue);
    }

    /**
     * @param string $Default
     *
     * @return Field
     */
    public function setDefaultValue($Default)
    {
        $this->DefaultValue = $Default;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHelperText()
    {
        return wp_unslash($this->HelperText);
    }

    /**
     * @param string $HelperText
     *
     * @return Field
     */
    public function setHelperText($HelperText)
    {

        $this->HelperText = sanitize_text_field($HelperText);

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {

        return wp_unslash($this->Placeholder);

    }

    /**
     * @param $Placeholder
     * @return Field
     *
     */
    public function setPlaceholder($Placeholder)
    {

        $this->Placeholder = sanitize_text_field($Placeholder);

        return $this;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->Ordering;
    }

    /**
     * @param int $Order
     * @return $this
     */
    public function setOrdering($Order)
    {
        if (absint($Order) == $Order) {
            $this->Ordering = $Order;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if (!empty($this->Label)) {
            return wp_unslash($this->Label);
        } else {
            return ucfirst($this->Type->getName());
        }
    }


    /**
     * @param string $Label
     *
     * @return Field
     */
    public function setLabel($Label)
    {
        $this->Label = sanitize_text_field($Label);

        return $this;
    }

    /**
     * @return int
     */
    public function getLabelPosition()
    {

        return $this->LabelPosition;

    }

    /**
     * @param $Value
     * @return Field
     *
     */
    public function setLabelPosition($Value)
    {

        if (absint($Value) == $Value) {
            $this->LabelPosition = $Value;
        }

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
     * @param int $Id
     *
     * @return Field
     */
    public function setForm($Id)
    {
        if (absint($Id) == $Id) {
            $this->Form = $Id;
        }

        return $this;
    }

    public function getTypeId()
    {
        return $this->TypeId;
    }

    public function setTypeId($TypeId)
    {
        return $this->setType($TypeId);
    }

    /**
     * @return FieldType
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param $TypeId
     * @return Field
     * @throws \Exception
     */
    public function setType($TypeId)
    {
        if (absint($TypeId) != $TypeId) {
            throw new \Exception('"TypeId" field must be non negative integer');
        }

        $this->TypeId = absint($TypeId);
        $this->Type = new FieldType(array('Id'=>$this->TypeId));

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {

        return $this->Class;

    }

    /**
     * @param string $Class
     *
     * @return Field
     */
    public function setClass($Class)
    {
        $this->Class = sanitize_text_field($Class);

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerClass()
    {

        return $this->ContainerClass;

    }

    /**
     * @param string $ContainerClass
     *
     * @return Field
     */
    public function setContainerClass($ContainerClass)
    {
        $this->ContainerClass = sanitize_text_field($ContainerClass);

        return $this;
    }

    /**
     * @return int(0,1)
     */
    public function getRequired()
    {

        return $this->Required;

    }

    /**
     * @param int $Required (0,1)
     *
     * @return Field
     */
    public function setRequired($Required)
    {
        if (in_array($Required, array(0, 1, 'on'))) {

            if ($Required == 'on') $Required = 1;
            $this->Required = intval($Required);

        }

        return $this;
    }

    /**
     * @return int(0,1)
     */
    public function getDisabled()
    {

        return $this->Disabled;

    }

    /**
     * @param int $Disabled (0,1)
     *
     * @return Field
     */
    public function setDisabled($Disabled)
    {
        if (in_array($Disabled, array(0, 1, 'on'))) {

            if ($Disabled == 'on') $Disabled = 1;
            $this->Disabled = intval($Disabled);

        }

        return $this;
    }

    public function setProperties($FieldSettings, $FieldId)
    {
        $this->setLabel($FieldSettings['label-' . $FieldId])
             ->setPlaceholder($FieldSettings['placeholder-' . $FieldId])
             ->setDefaultValue($FieldSettings['default-' . $FieldId])
             ->setLabelPosition($FieldSettings['position-' . $FieldId])
             ->setClass($FieldSettings['class-' . $FieldId])
             ->setContainerClass($FieldSettings['contclass-' . $FieldId])
             ->setRequired($FieldSettings['required-' . $FieldId])
             ->setDisabled($FieldSettings['disabled-' . $FieldId])
             ->setOrdering($FieldSettings['order-' . $FieldId])
             ->setHelperText($FieldSettings['helptext-' . $FieldId]);
    }

    public function fieldBlock()
    {
        $field_block_html = '<div class="field-block ui-state-default ui-sortable-handle" data-field-id="' . $this->Id . '" data-field-type="' . $this->getType()->getId() . '">';
        $field_block_html .= '<i class="gdicon gdicon-' . $this->getType()->getName() . '"></i>';
        $field_block_html .= '<span class="field_name">' . $this->getLabel() . '</span>';
        $field_block_html .= '<i class="gdicon gdicon-duplicate"></i><i class="gdicon gdicon-remove"></i><i class="gdicon gdicon-setting"></i>';
        $field_block_html .= '</div>';

        return $field_block_html;
    }

    public function fieldClass()
    {
        $class = '';
        $label_position = $this->LabelPosition;

        switch ($label_position) {
            case '1': /* default */
                $form = new Form(array('Id'=>$this->getForm()));
                $form_label_position = $form->getLabelsPosition()->getId();
                switch ($form_label_position) {
                    case '1':
                        break;
                    case '2':
                        $class .= 'label-left';
                        break;
                    case '3':
                        $class .= 'label-right';
                        break;
                    case '4':
                        $class .= '';
                        break;
                    case '5':
                        $class .= 'label-hidden';
                        break;

                }
                break;
            case '2':
                $class .= 'label-left';
                break;
            case '3':
                $class .= 'label-right';
                break;
            case '4':
                $class .= '';
                break;
            case '5':
                $class .= 'label-hidden';
                break;

        }

        $class .= ' ' . $this->ContainerClass;
        $class .= ' gdfrm-' . $this->getType()->getName();
        $class .= ' field-' . $this->getId();

        if ($this->Required) $class .= ' gdfrm-required';

        return $class;
    }

    /* description text displayed under inputs */
    public function helpTextBlock()
    {
        if ($this->getHelperText() !== ''): ?>
            <div class="help-block">
                <?php echo $this->getHelperText(); ?>
            </div>
        <?php endif;
    }

    /* error messages displayed under inputs when form is submitted*/
    public function errorTextBlock()
    { ?>
        <div class="error-block">
        </div>
        <?php
    }

    public function requiredBlock()
    {
        if ($this->Required): ?>
            <span class="gdfrm-required">*</span>
        <?php endif;
    }

    /**
     * @return Form
     */
    public function getFormObject()
    {
        if (null === $this->FormObject) {
            $this->FormObject = new Form(array('Id'=>$this->Form));
        }
        return $this->FormObject;
    }

    abstract function settingsBlock();

    abstract function fieldHtml();

    public static function get($args = array())
    {
        global $wpdb;
        $id = $args['Id'];
        $type = $wpdb->get_var($wpdb->prepare("SELECT types.Id FROM " . static::getTableName() . " as fields INNER JOIN  " . FieldType::getTableName() . " as types ON fields.TypeId=types.Id WHERE fields.Id=%d", $id));
        $fieldType = new FieldType(array('Id'=>$type));

        if($fieldType->getIsFree()){
            $className = "\GDForm\Models\Fields\\" . ucfirst($fieldType->getName());
            return new $className(array('Id' => $id));
        }
    }

}