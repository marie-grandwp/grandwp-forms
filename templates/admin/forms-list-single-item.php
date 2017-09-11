<?php
/**
 * Template for forms list single item
 *
 * @var $form \GDForm\Models\Form
 */

$FormId = $form->getId();

$FormSubmissionsUrl = admin_url('admin.php?page=gdfrm_submissions&form=' . $FormId);

$EditUrl = admin_url('admin.php?page=gdfrm&task=edit_form&id=' . $FormId);

$EditUrl = wp_nonce_url($EditUrl, 'gdfrm_edit_form_' . $FormId);

$RemoveUrl = admin_url('admin.php?page=gdfrm&task=remove_form&id=' . $FormId);

$RemoveUrl = wp_nonce_url($RemoveUrl, 'gdfrm_remove_form_' . $FormId);

$DuplicateUrl = admin_url('admin.php?page=gdfrm&task=duplicate_form&id=' . $FormId);

$DuplicateUrl = wp_nonce_url($DuplicateUrl, 'gdfrm_duplicate_form_' . $FormId);

$FoundSubmissions = \GDForm\Models\Submission::get(array(
    'where' => array(
        'Form' => $FormId
    )
));

?>
<tr>
    <td class="form-id"><input type="checkbox" class="item-checkbox" name="items[]" value="<?php echo $FormId; ?>">
    </td>
    <td class="form-name"><a
                href="<?php echo $EditUrl; ?>"><?php echo esc_html(stripslashes($form->getName())); ?></a></td>
    <td class="form-fields"><?php echo count($form->getFields()); ?></td>
    <td class="form-submissions"><a class=""
                                    href="<?php echo $FormSubmissionsUrl; ?>"><?php echo count($FoundSubmissions); ?></a>
    </td>
    <td class="form-shortcode" style="font-size: 12px;">
        [gdfrm_form id="<?php echo $FormId; ?>"]<br>
        &lt;?php echo do_shortcode("[gdfrm_form id='<?php echo $FormId; ?>']"); ?&gt;
    </td>
    <td class="form-actions">
        <a class="gdfrm_edit_form" href="<?php echo $EditUrl; ?>"><i class="gdicon gdicon-setting"
                                                                     aria-hidden="true"></i></a>
        <a class="gdfrm_duplicate_form" href="<?php echo $DuplicateUrl; ?>"><i class="gdicon gdicon-duplicate"
                                                                               aria-hidden="true"></i></a>
        <a class="gdfrm_delete_form" href="<?php echo $RemoveUrl; ?>"><i class="gdicon gdicon-remove"
                                                                         aria-hidden="true"></i></a>
        <a class="gdfrm_preview_form" target="_blank"
           href="<?php echo \GDForm\Controllers\Frontend\FormPreviewController::previewUrl($form->getId(), false); ?>"><i class="gdicon gdicon-eye"
                                                                                       aria-hidden="true"></i></a>
    </td>
</tr>
