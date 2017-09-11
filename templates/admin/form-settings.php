<?php
/**
 * Template for edit form settings page
 * @var $form \GDForm\Models\Form
 */
use GDForm\Controllers\Frontend\FormPreviewController as Preview;

global $wpdb;

$edit_form_link = admin_url( 'admin.php?page=gdfrm&task=edit_form&id='.$form->getId() );

$edit_form_link = wp_nonce_url( $edit_form_link, 'gdfrm_edit_form_' . $form->getId()  );
?>
<div class="wrap gdfrm_edit_form_settings_container <?php if( isset($_COOKIE['grandFormsFullWidth']) && $_COOKIE['grandFormsFullWidth'] == "yes" ){ echo 'gdfrm-fullwidth-view'; } ?>" data-form="<?php echo $form->getId();?>">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('GrandWP Forms',GDFRM_TEXT_DOMAIN);?></span>

        <ul>
            <li>
                <a href="http://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_nav">
        <div class="form_title_div">
            <input type="text" id="form_name" value="<?php echo $form->getName(); ?>">
            <input type="hidden" id="form_id" value="<?php echo $form->getId(); ?>">
        </div>

        <ul>
            <li>
                <a href="<?php echo $edit_form_link; ?>"><?php _e('Fields', GDFRM_TEXT_DOMAIN); ?></a>
            </li>
            <li class="active">
                <a href=""><?php _e('Form Settings', GDFRM_TEXT_DOMAIN); ?></a>
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
            <span id="save-form-button"><?php _e('Save');?></span>
        </div>
    </div>

    <div class="gdfrm_content">
        <form id="grand-form-settings" >
            <div class="left-col">
                <table>
                    <tr>
                        <td>
                            <label for="save-submissions">
                                <input type="checkbox" class="switch-checkbox" id="save-submissions" name="save-submissions" <?php checked(1,$form->getSaveSubmissions()); ?>><span class="switch" ></span>
                            </label>
                        </td>
                        <td>
                            <?php _e('Save Submissions to Database',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email-users">
                                <input type="checkbox" class="switch-checkbox" id="email-users" name="email-users" <?php checked(1,$form->getEmailUsers()); ?>><span class="switch" ></span>
                            </label>
                        </td>
                        <td>
                            <?php _e('Email to Users',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="email-user-settings"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email-admin">
                                <input type="checkbox" class="switch-checkbox" id="email-admin" name="email-admin" <?php checked(1,$form->getEmailAdmin()); ?>><span class="switch" ></span>
                            </label>
                        </td>
                        <td>
                            <?php _e('Email to Admin',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="email-admin-settings"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gdfrm-green-button"><?php _e('Display',GDFRM_TEXT_DOMAIN);?></span>
                        </td>
                        <td>
                            <?php _e('Form Display Settings',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="display-settings"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gdfrm-green-button"><?php _e('Submit',GDFRM_TEXT_DOMAIN);?></span>
                        </td>
                        <td>
                            <?php _e('Actions on Form Submit',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="action-onsubmit-settings"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gdfrm-green-button"><?php _e('Errors',GDFRM_TEXT_DOMAIN);?></span>
                        </td>
                        <td>
                            <?php _e('Form Notices',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="form-notices"></i>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="payments-enabled">
                                <input type="checkbox" disabled class="switch-checkbox" id="payments-enabled" ><span class="switch" ></span>
                            </label>
                        </td>
                        <td class="pro-feature">
                            <?php _e('Enable Payments',GDFRM_TEXT_DOMAIN);?>
                        </td>
                        <td>
                            <i class="gdicon gdicon-setting relative" rel="form-payment"></i>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="right-col whitebg">
                <span class="hide-rightcol"><i class="fa fa-chevron-right"></i> </span>

                <!-- Send Email to Admin -->
                <div id="email-admin-settings">
                    <div class="setting-title"><?php _e('Email Admin',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label><?php _e('Admin Email',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="email" name="admin-email" value="<?php echo $form->getAdminEmail(); ?>" >
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Mail Subject',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="admin-subject" value="<?php echo $form->getAdminSubject(); ?>" >
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Mail Message',GDFRM_TEXT_DOMAIN);?></label>
                        <?php
                            wp_editor($form->getAdminMessage(),'admin-message', array('editor_class'=>'setting-row'));
                        ?>
                    </div>
                </div>

                <!-- Send Email to User -->
                <div id="email-user-settings">
                    <div class="setting-title"><?php _e('Email Users',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label><?php _e('From Name',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="email-from-name" value="<?php echo $form->getFromName(); ?>" >
                    </div>
                    <div class="setting-row">
                        <label><?php _e('From Email',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="email" name="email-from-address" value="<?php echo $form->getFromEmail(); ?>" >
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Mail Subject',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="user-subject" value="<?php echo $form->getUserSubject(); ?>">
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Mail Message',GDFRM_TEXT_DOMAIN);?></label>
                        <?php
                        wp_editor($form->getUserMessage(),'user-message', array('editor_class'=>'setting-row'));
                        ?>
                    </div>
                </div>

                <!-- Form Submit -->
                <div id="action-onsubmit-settings">
                    <div class="setting-title"><?php _e('Action on Form Submit',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label><?php _e('Action on Submit',GDFRM_TEXT_DOMAIN);?></label>
                        <select name="action-onsubmit" >
                            <?php $actions= \GDForm\Models\OnsubmitAction::get();?>
                            <?php foreach ($actions as $action){ ?>
                                <option value="<?php echo $action->getId();?>" <?php selected($action->getId(),$form->getActionOnsubmit()->getId());?> >
                                    <?php echo $action->getName();?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="setting-row action-onsubmit <?php if($form->getActionOnsubmit()->getId()==1) echo 'visible';?>" rel="action-1">
                        <div class="setting-row">
                            <label>
                                <?php _e('Hide Form on Submit',GDFRM_TEXT_DOMAIN);?>
                                <input type="checkbox" class="switch-checkbox" name="hide-form" <?php checked(1,$form->getHideFormOnsubmit()); ?>>
                                <span class="switch"></span>
                            </label>
                        </div>

                        <label><?php _e('Success Message',GDFRM_TEXT_DOMAIN);?></label>
                        <?php wp_editor($form->getSuccessMessage(),'success-message', array('editor_class'=>'setting-row'));?>
                    </div>

                    <div class="setting-row action-onsubmit <?php if($form->getActionOnsubmit()->getId()==2) echo 'visible';?>" rel="action-2">
                        <label><?php _e('Redirect URL',GDFRM_TEXT_DOMAIN);?></label>
                        <textarea name="redirect-url"><?php echo $form->getRedirectUrl(); ?></textarea>
                    </div>

                </div>

                <!-- Form Display Settings -->
                <div id="display-settings">
                    <div class="setting-title"><?php _e('Display Settings',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label>
                            <?php _e('Display Title',GDFRM_TEXT_DOMAIN);?>
                            <input type="checkbox" class="switch-checkbox" name="display-title" <?php checked(1,$form->getDisplayTitle()); ?>>
                            <span class="switch"></span>
                        </label>
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Labels Position',GDFRM_TEXT_DOMAIN);?></label>
                        <select name="labels-position">
                            <?php $label_positions= \GDForm\Models\LabelPosition::get();?>
                            <?php foreach ($label_positions as $label_position){ if($label_position->getName()!='default'): ?>
                                <option value="<?php echo $label_position->getId();?>" <?php selected($label_position->getId(),$form->getLabelsPosition()->getId());?> ><?php echo ucfirst($label_position->getName());?></option>
                            <?php endif; } ?>
                        </select>
                    </div>
                </div>

                <!-- Form Notices -->
                <div id="form-notices">
                    <div class="setting-title"><?php _e('Form Notice and Error Messages',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label><?php _e('Wrong Email Format',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="email-format-error" value="<?php echo $form->getEmailFormatError(); ?>">
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Required Field Is Empty',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="required-field-error" value="<?php echo $form->getRequiredEmptyError(); ?>">
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Uploaded Size Exceeded',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="upload-size-error" value="<?php echo $form->getUploadSizeError(); ?>">
                    </div>
                    <div class="setting-row">
                        <label><?php _e('Wrong File Format',GDFRM_TEXT_DOMAIN);?></label>
                        <input type="text" name="upload-format-error" value="<?php echo $form->getUploadFormatError(); ?>">
                    </div>
                </div>

                <!-- Form Payment Settings -->
                <div id="form-payment" class="pro-feature">
                    <div class="setting-title"><?php _e('Form Payment Settings',GDFRM_TEXT_DOMAIN);?></div>
                    <div class="setting-row">
                        <label><?php _e('Available Payment Gateways',GDFRM_TEXT_DOMAIN);?></label>
                        <select  disabled>
                            <option value="paypal"  >
                                <?php _e('Paypal',GDFRM_TEXT_DOMAIN);?>
                            </option>
                            <option value="stripe" disabled="true" >
                                <?php _e('Stripe (Coming Soon)',GDFRM_TEXT_DOMAIN);?>
                            </option>
                            <option value="elavon" disabled="true" >
                                <?php _e('Elavon (Coming Soon)',GDFRM_TEXT_DOMAIN);?>
                            </option>
                        </select>


                    </div>

                    <div class="setting-row payment-gateway visible" rel="gateway-paypal">
                        <label><?php _e('Paypal Settings',GDFRM_TEXT_DOMAIN);?></label>

                        <ul>
                            <li>
                                <input type="radio" id="paypal-live" value="live" disabled >
                                <label for="paypal-live">Live</label>

                                <div class="check"></div>
                            </li>

                            <li>
                                <input type="radio" id="paypal-test"  value="sandbox" checked disabled>
                                <label for="paypal-test">Sandbox</label>

                                <div class="check"></div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
