<?php
$new_form_link = admin_url( 'admin.php?page=gdfrm&task=create_new_form' );

$new_form_link = wp_nonce_url( $new_form_link, 'gdfrm_create_new_form' );
?>
<tr><td colspan="6"><?php _e('No Forms Found.',GDFRM_TEXT_DOMAIN);?> <a href="<?php echo $new_form_link;?>"><?php _e('Add New',GDFRM_TEXT_DOMAIN);?></a></td></tr>