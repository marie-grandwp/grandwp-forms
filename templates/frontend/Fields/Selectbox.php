<?php
/**
 * @var $field \GDForm\Models\Fields\Selectbox
 */
?>
<div class="gdfrm-form-field <?php echo $field->fieldClass();?>">

    <label for="">
        <?php echo $field->getLabel();?>
        <?php echo $field->requiredBlock();?>
    </label>
    <div>
        <select <?php if($field->getOptionType()=='multiselect'):?>multiple="multiple" <?php endif;?>
                <?php if($field->getSearchOn()):?>search="1"<?php endif;?>
                name="field-<?php echo $field->getId();?>[]"
                class="select2 <?php echo $field->getClass();?>">
            <option></option>
            <?php $options = $field->getOptions();
            foreach ( $options as $option){ ?>
                <option value="<?php echo ($option->getValue())?$option->getValue():$option->getName();?>"><?php echo $option->getName();?></option>
            <?php } ?>
        </select>
        <?php $field->helpTextBlock();?>
        <?php $field->errorTextBlock();?>
    </div>
</div>
