<?php
if (!defined('CT_CHARTS_JS_PATH')){
	define ('CT_CHARTS_JS_PATH', CT_THEME_SETTINGS_MAIN_DIR . '/plugin/chart-js-plugin');
}

/**
 * fddfs
 * @author createit
 */

class ctChartJsPlugin {

	public function __construct() {
		ctThemeLoader::getFilesLoader()->includeOnceByPattern(  CT_THEME_LIB_DIR . '/shortcodes' );
		ctThemeLoader::getFilesLoader()->requireOnce( CT_THEME_SETTINGS_MAIN_DIR . '/plugin/visual-composer/ctVisualComposerShortcodeInterface.php');
		ctThemeLoader::getFilesLoader()->includeOnceByPattern( CT_THEME_PLUGINS . '/chart-js-plugin/shortcodes/' );
	}
}

new ctChartJsPlugin();