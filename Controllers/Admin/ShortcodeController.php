<?php

namespace GDForm\Controllers\Admin;

use GDForm\Helpers\View;

class ShortcodeController
{

    public static function showInlinePopup()
    {
        View::render( 'admin/inline-popup.php' );
    }

    public static function showEditorMediaButton($context)
    {
        $img          = untrailingslashit( \GDForm()->pluginUrl() ) . "/assets/images/forms_logo.png";
        $container_id = 'gdfrm';
        $title        = __( 'Insert Form', GDFRM_TEXT_DOMAIN );
        $button_text  = __( 'Grand Form', GDFRM_TEXT_DOMAIN );
        $context .= '<a class="button thickbox" title="' . $title . '"    href="#TB_inline?width=400&inlineId=' . $container_id . '">
		<span class="wp-media-buttons-icon" style="background: url(' . $img . '); background-repeat: no-repeat; background-position: left bottom;background-size: 18px 18px;"></span>' . $button_text . '</a>';

        return $context;
    }
    
}