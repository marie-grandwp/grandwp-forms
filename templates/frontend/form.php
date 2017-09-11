<?php
/**
 * @var $form \GDForm\Models\Form
 */
?>
<div class="gdfrm-form-container">
    <form autocomplete="off" action="" method="" class="gdfrm-form" form-id="<?php echo $form->getId();?>" id="gdfrm-<?php echo $form->getId();?>" enctype='multipart/form-data'>
        <?php if ($form->getDisplayTitle()):?>
            <div class="gdfrm-form-title">
                <span><?php echo $form->getName();?></span>
            </div>
        <?php endif;?>

        <?php
        $fields = $form->getFields();
        if(!empty($fields)){
            foreach ( $fields as $field ) {
                if($field) $field->fieldHtml();
            }
        }
        ?>
        <input type="hidden" class="required-empty-error" value="<?php echo $form->getRequiredEmptyError();?>">
        <input type="hidden" class="email-format-error" value="<?php echo $form->getEmailFormatError();?>">
        <input type="hidden" class="upload-size-error" value="<?php echo $form->getUploadSizeError();?>">
        <input type="hidden" class="file-format-error" value="<?php echo $form->getUploadFormatError();?>">

        <div class="form_loading_icon"><img src="<?php echo GDFRM_IMAGES_URL.'loading.gif' ?>"> </div>
    </form>
</div>





