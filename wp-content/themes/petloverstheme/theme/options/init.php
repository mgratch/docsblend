<?php
//in which order we embed tabs
$order = array('general', 'footer',  'code', 'custom');

$args['menu_title'] = __('Theme Options', 'ct_theme');
$args['page_title'] = __('PetLovers Options', 'ct_theme');

$args['intro_text'] = __('Welcome to theme\'s options pages.', 'ct_theme');

$args['page_type'] = 'submenu';

$args['show_import_export'] = false;
$args['dev_mode'] = false;

$args['opt_name'] = 'fishtank_options';
$args['page_position'] = 27;

$args['show_import_export'] = true;


?>