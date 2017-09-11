<?php

namespace GDForm\Controllers\Widgets;

class WidgetsController
{
    public static function init()
    {
        register_widget( 'GDForm\Controllers\Widgets\FormWidgetController' );
    }
}