<?php
/**
 * Template for edit form page
 * @var $form \GDForm\Models\Form
 */

use GDForm\Controllers\Frontend\FormPreviewController as Preview;

global $wpdb;

$form_settings_link = admin_url('admin.php?page=gdfrm&task=edit_form_settings&id=' . $form->getId());

$form_settings_link = wp_nonce_url($form_settings_link, 'gdfrm_edit_form_settings_' . $form->getId());

?>
<div class="wrap gdfrm_edit_form_container <?php if (isset($_COOKIE['grandFormsFullWidth']) && $_COOKIE['grandFormsFullWidth'] == "yes") {
    echo 'gdfrm-fullwidth-view';
} ?>" data-form="<?php echo $form->getId(); ?>">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('GrandWP Forms', GDFRM_TEXT_DOMAIN); ?></span>

        <ul>
            <li>
                <a href="http://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro', GDFRM_TEXT_DOMAIN); ?></a>
            </li>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help', GDFRM_TEXT_DOMAIN); ?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_nav">
        <div class="form_title_div">
            <input type="text" id="form_name" value="<?php echo $form->getName(); ?>">
            <input type="hidden" id="form_id" value="<?php echo $form->getId(); ?>">
        </div>

        <ul>
            <li class="active">
                <a href=""><?php _e('Fields', GDFRM_TEXT_DOMAIN); ?></a>
            </li>
            <li>
                <a href="<?php echo $form_settings_link; ?>"><?php _e('Form Settings', GDFRM_TEXT_DOMAIN); ?></a>
            </li>
            <li id="preview-form" data-form="<?php echo $form->getId();?>">
                <?php echo Preview::previewUrl($form->getId()); ?>
            </li>
            <li>
                <a href="" class="popup-trigger" data-target="shortcode-popup"><?php _e('Shortcode', GDFRM_TEXT_DOMAIN); ?></a>
                <div id="shortcode-popup" class="popup" >
                    <div style="text-align: right"><i class="fa fa-times" aria-hidden="true"></i></div>
                    <p>Use this shortcode to publish the form directly to WordPress post/page. <span > [gdfrm_form id="<?php echo $form->getId();?>"] </span></p>
                    <p>Use this php code snippet to include the created form in your theme. <span > &lt;?php echo do_shortcode("[gdfrm_form id='<?php echo $form->getId();?>']"); ?&gt; </span>  </p>
                </div>
            </li>
        </ul>

        <div class="gdfrm_subheader">
                <span id="save-form-button"><?php _e('Save'); ?></span>
                <span id="add-new-field"><?php _e('Add New Field'); ?><i class="gdicon gdicon-plus"></i></span>
        </div>
    </div>

    <div class="gdfrm_content">
        <form id="grand-form" name="grandFormEdit">
            <div class="left-col">
                <div class="droptrue" id="fields-list">
                    <?php
                    if (!empty($fields)):
                        foreach ($fields as $key => $field) {
                            if($field) echo $field->fieldBlock();
                        }
                    endif;
                    ?>
                </div>

                <input type="hidden" id="submit-notice-shown" value="<?php echo $form->getSubmitNoticeShown();?>">
            </div>

            <div class="right-col">
                <span class="hide-rightcol"><i class="fa fa-chevron-right"></i> </span>

                <div class="tobefixed">
                    <div id="type-blocks-list">
                        <div class="block-title"><?php _e('Common Fields', GDFRM_TEXT_DOMAIN); ?></div>

                        <?php $fieldTypes = \GDForm\Models\FieldType::get();
                        foreach ($fieldTypes as $key => $fieldType) {
                            $isPro = ($fieldType->getIsFree()=='0');
                            $class = ($isPro)?'pro-field':'';
                            $html = '<div class="type-block '.$class.'  gdicon gdicon-' . $fieldType->getName() . '" type-id="' . $fieldType->getId() . '" >';
                            $html .= '<span>' . ucfirst($fieldType->getName()) . '</span>';
                            if($isPro) $html .= '<span class="pro-field">Pro</span>';
                            $html .= '</div>';
                            echo $html;
                        }
                        ?>
                    </div>

                    <div class="" id="settings-list">
                        <?php
                        if (!empty($fields)):
                            foreach ($fields as $key => $field) {
                            if($field)  echo $field->settingsBlock();
                            }
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>