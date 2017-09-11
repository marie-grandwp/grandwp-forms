<?php

namespace GDForm\Controllers\Frontend;


class FrontendController
{

    public function __construct()
    {
        add_shortcode( 'gdfrm_form', array( 'GDForm\Controllers\Frontend\ShortcodeController', 'run' ) );
        new FormPreviewController();
        FrontendAssetsController::init();
    }

}