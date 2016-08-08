<?php
if (!defined('CT_ADVANCED_CUSTOMIZER_PATH')){
	define ('CT_ADVANCED_CUSTOMIZER_PATH', CT_THEME_SETTINGS_MAIN_DIR . '/plugin/advanced-customizer');
}
require_once CT_ADVANCED_CUSTOMIZER_PATH.'/ctAdvancedCustomizer.class.php';
//echo ctAdvancedCustomizer::renderLessToCss('/var/www/ct10/wp/wp-content/themes/pluto/theme-woo/assets/less/style.less');