<?php

namespace GDForm\Controllers\Frontend;

use GDForm\Helpers\View;
use GDForm\Models\Form;

class ShortcodeController
{

    public static function run($attrs)
    {
        $attrs = shortcode_atts(array(
            'id' => false,
        ), $attrs);

        if (!$attrs['id'] || absint($attrs['id']) != $attrs['id']) {
            throw new \Exception('"id" parameter is required and must be not negative integer.');
        }


        do_action('gdfrmShortcodeScripts', $attrs['id']);

        return self::show($attrs['id']);
    }

    private static function show($id)
    {
        ob_start();

        $form = new Form( array('Id'=>$id) );

        View::render( 'frontend/form.php', array( 'form' => $form ) );

        return ob_get_clean();
    }

}