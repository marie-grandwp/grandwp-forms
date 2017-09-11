<?php

$forms = \GDForm\Models\Form::get();

?>
<style>
    .tb_popup_form {
        position: relative;
        display: block;
    }

    .tb_popup_form li {
        display: block;
        height: 35px;
        width: 70%;
    }

    .tb_popup_form li label {
        float: left;
        width: 35%
    }

    .tb_popup_form li input {
        float: left;
        width: 60%;
    }

    .slider, .slider-container {
        display: block;
        position: relative;
        height: 35px;
        line-height: 35px;
    }


</style>
<div id="gdfrm" style="display:none;">
    <?php

    $new_form_link = admin_url('admin.php?page=gdfrm&task=create_new_form');

    $new_form_link = wp_nonce_url($new_form_link, 'gdfrm_create_new_form');

    if( $forms && !empty($forms) ){
        \GDForm\Helpers\View::render('admin/inline-popup-form.php', array( 'forms' => $forms ));
    }else{
        printf(
            '<p>%s<a class="button" href="%s">%s</a></p>',
            __('You have not created any forms yet', GDFRM_TEXT_DOMAIN).'<br>',
            $new_form_link,
            __( 'Create New Form', GDFRM_TEXT_DOMAIN )
        );
    }

    ?>
</div>
