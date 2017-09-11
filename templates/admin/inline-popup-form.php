<?php
/**
 * @var $forms \GDForm\Models\Form[]
 */

?>

<form method="post" action="" >
    <h3>Select The Form To Embed</h3>

    <select id="grand_form_select" style="width:100%">
        <?php
        foreach ( $forms as $form ) {
            ?>
                <option value="<?php echo $form->getId(); ?>"><?php echo $form->getName(); ?></option>
            <?php
        }
        ?>
    </select>
    <button class='button primary' id='grand_form_insert' style="position: absolute;bottom: 20px;background: #692222;color: #fff;border: none; right: 30px;">
        <?php _e( 'Insert Form', GDFRM_TEXT_DOMAIN ); ?>
    </button>
    <button class='button primary' style="position: absolute;bottom: 25px;left: 30px" id='gd_form_cancel'>
        <?php _e( 'Cancel', GDFRM_TEXT_DOMAIN ); ?>
    </button>
</form>
