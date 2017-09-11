<?php
/**
 * Plugin Name: GrandWP Forms
 * Author: GrandWP
 * Description: Easy to use Form Plugin for creating simple to custom complex forms
 * Version: 1.0.2
 * Domain Path: /languages
 * Text Domain: gdfrm
 */

if(!defined('ABSPATH')){
    exit();
}

require 'autoload.php';

require 'GDForm.php';


/**
 * Main instance of GDForm.
 *
 * Returns the main instance of GDForm to prevent the need to use globals.
 *
 * @return \GDForm\GDForm
 */

function GDForm()
{
    return \GDForm\GDForm::instance();
}

$GLOBALS['GDForm'] = GDForm();