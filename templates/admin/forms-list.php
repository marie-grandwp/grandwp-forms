<?php
/**
 * Template for main forms list
 */
global $wpdb;

$new_form_link = admin_url('admin.php?page=gdfrm&task=create_new_form');

$new_form_link = wp_nonce_url($new_form_link, 'gdfrm_create_new_form');

$form_templates_link = admin_url('admin.php?page=gdfrm&task=choose_form_template');

$form_templates_link = wp_nonce_url($form_templates_link, 'gdfrm_choose_form_template');

?>
<div class="wrap gdfrm_list_container ">
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


    <div class="gdfrm_content">

        <div class="gdfrm-list-header">
            <div>
                <a href="<?php echo $new_form_link; ?>" id="gdfrm-new-form"><?php _e('Add New Form',GDFRM_TEXT_DOMAIN);?></a>
            </div>

        </div>

        <div class="tablenav top ">
            <div class="alignleft actions bulkactions">
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1">Bulk Actions</option>
                    <option value="trash">Move to Trash</option>
                </select>
                <input type="submit" id="doaction" name="doaction" class="button action" value="Apply">
            </div>

            <div class="alignright actions">
                <?php $perpage = \GDForm()->Settings->get('PostsPerPage'); ?>

                <?php echo \GDForm\Helpers\View::pagination(\GDForm\Models\Form::getAllItemsCount(), $perpage); ?>
            </div>
        </div>
        <table class="widefat striped fixed forms_table">
            <thead>
            <tr>
                <th scope="col" id="header-id" style="width:10px"><span><input type="checkbox"
                                                                               id="select-all"></span></span></th>
                <th scope="col" id="header-name" style="width:85px"><span><?php _e('Name', GDFRM_TEXT_DOMAIN); ?></span>
                </th>
                <th scope="col" id="header-fields" style="width:85px">
                    <span><?php _e('Fields', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th scope="col" id="header-fields" style="width:85px">
                    <span><?php _e('Submissions', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th scope="col" id="header-shortcode" style="width:85px">
                    <span><?php _e('Shortcode', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th style="width:60px"><?php _e('Actions', GDFRM_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

            $forms = \GDForm\Models\Form::get(array(
                'per_page' => $perpage,
                'paged' => $paged,
                'where' => array(
                    'IsPreview' => 0
                )
            ));
            if (!empty($forms)) {
                foreach ($forms as $form) {
                    \GDForm\Helpers\View::render('admin/forms-list-single-item.php', array('form' => $form));
                }
            } else {
                \GDForm\Helpers\View::render('admin/forms-list-no-items.php');
            }
            ?>
            </tbody>

            <tfoot>
            <tr>
                <th scope="col" class="footer-id" style="width:30px"></th>
                <th scope="col" class="footer-name" style="width:85px">
                    <span><?php _e('Name', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th scope="col" class="footer-fields" style="width:85px">
                    <span><?php _e('Fields', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th scope="col" class="footer-fields" style="width:85px">
                    <span><?php _e('Submissions', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th scope="col" class="footer-shortcode" style="width:85px">
                    <span><?php _e('Shortcode', GDFRM_TEXT_DOMAIN); ?></span></th>
                <th style="width:60px"><?php _e('Actions', GDFRM_TEXT_DOMAIN); ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>