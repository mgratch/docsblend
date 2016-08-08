<?php
/**
 *
 * @author scyzoryck
 */

if (!defined('CT_ADVANCED_CUSTOMIZER_PATH')) {
    define('CT_ADVANCED_CUSTOMIZER_PATH', CT_THEME_SETTINGS_MAIN_DIR . '/plugin/advanced-customizer');
}
global $wp_customize;


class ctAdvancedCustomizer
{

    /**
     * @var ctControlsMapper
     */
    protected $mapper = null;

    protected $stylesNames = array(
        'style',
        'style2',
        'style3',
    );
    protected $styles = array();

    protected $fonts = array();

    protected $lessVariables = 'variables';

    protected $lessDir = '';

    protected $cssDir = '';

    protected $cssUrl = '';

    protected $imageUploads = array();

    protected $variablesToCompile = array();

    /**
     * Is preview?
     * @var bool
     */

    protected $isPreview = false;

    protected $priorites = array(
        'panels' => 0,
        'sections' => 0,
        'controls' => 0,
    );
    protected $description = 'mydesc';

    public function getDescription()
    {
        return $this->description;
    }

    public function __construct()
    {
        if (!apply_filters('ct_customizer_disable', false)) {
            ctThemeLoader::getFilesLoader()->includeOnce(CT_ADVANCED_CUSTOMIZER_PATH . '/lib/ctAdvancedCustomizerMethods.class.php');
            ctThemeLoader::getFilesLoader()->includeOnceByPattern(CT_ADVANCED_CUSTOMIZER_PATH . '/controls');
            ctThemeLoader::getFilesLoader()->includeOnce(CT_ADVANCED_CUSTOMIZER_PATH . '/mapper/ctControlsMapper.class.php');
            ctThemeLoader::getFilesLoader()->includeOnceByPattern(CT_ADVANCED_CUSTOMIZER_PATH . '/less/less_php');
            ctThemeLoader::getFilesLoader()->includeOnceByPattern(CT_ADVANCED_CUSTOMIZER_PATH . '/less/lessphp');
            ctThemeLoader::getFilesLoader()->includeOnce(CT_ADVANCED_CUSTOMIZER_PATH . '/lib/ctAdvancedCustomizerDefaultValues.class.php');


            $this->lessDir = CT_THEME_DIR . '/assets/less';

            $this->setCssDir();
            $this->setCssUrl();

            $fonts = unserialize(get_option('ct_customizer_fonts' . THEME_NAME, ''));
            if (is_array($fonts)) {
                $this->fonts = $fonts;
            }
            add_action('init', array($this, 'renderLessToCss'), 1);
            add_action('customize_preview_init', array($this, 'previewAction'), 1);
//		add_action( 'upgrader_process_complete', array( $this, 'updateAction' ) );
            add_action('customize_register', array($this, 'customizeRegister'), 20);
            add_action('customize_save_after', array($this, 'saveAction'));

            //enable/disable CSS overwrite for dev needs.
            if (apply_filters('ct_customizer.overwrite_styles', true)) {
                if ($this->hasCustomStyles()) {
                    //remove default styles
                    add_filter('ct_theme_loader.load_styles', '__return_false');
                }
                add_action('wp_enqueue_scripts', array($this, 'registerStyles'));
            }

            add_action('customize_controls_enqueue_scripts', array($this, 'registerContolsStyles'));
            add_action('customize_controls_print_footer_scripts', array($this, 'customizerInfo'));
            add_action('after_switch_theme', array($this, 'saveDefaultValues'));


        }
    }


    public function setVariablesToCompile()
    {

        ctThemeLoader::getFilesLoader()->requireOnce(CT_ADVANCED_CUSTOMIZER_PATH . '/lib/ctAdvancedCustomizerDefaultValues.class.php');
        $mapper = apply_filters('ct_customizer_mapper.configure', new ctDefaultValues('get_variables'));    //
        $this->variablesToCompile = $mapper->variablesToCompile;

    }

    public function saveDefaultValues()
    {
        //load plugin - we can't relay on loading order here
        ctThemeLoader::getFilesLoader()->requireOnce(CT_ADVANCED_CUSTOMIZER_PATH . '/lib/ctAdvancedCustomizerDefaultValues.class.php');
        $defaults = new ctDefaultValues();
        $defaults = apply_filters('ct_customizer_default_values_save', $defaults);


    }

    /**
     * @param $variablesToCompile
     */

    public function uberMenu($variablesToCompile)
    {
        $lessFilename = apply_filters('uberMenuLessFileName', $lessFilename = 'ubermenu');
        $lessPath = apply_filters('uberMenuLessPath', $lessPath = '');

        $options = array('compress' => true);

        $path = $this->getLessDir() . '/' . $lessPath . $lessFilename . '.less';

        if (file_exists($path)) {
            try {
                $parser = new Less_Parser($options);
                $parser->parseFile($path);
                $parser->ModifyVars($variablesToCompile);
                $css = $parser->getCss();
            } catch (\Exception $e) {
                try {
                    $lessc = new lessc_old($path);
                    $lessc->setPreserveComments(false);
                    $lessc->setVariables($variablesToCompile);
                    $css = $lessc->parse();
                } catch (\Exception $e) {
                    $lessc = new lessc($path);
                    $lessc->setPreserveComments(false);
                    $lessc->setVariables($variablesToCompile);
                    $css = $lessc->parse(false);
                    echo esc_html($lessFilename) . ' parse error!';
                }
            }

        } else {
            $css = '';
        }
        $uberMenuCssFilename = 'custom';
        $uberMenuDir = ABSPATH . '/wp-content/plugins/ubermenu/custom/';
        $path = $uberMenuDir . $uberMenuCssFilename . '.css';

        if ($css != '') {
            if (!file_exists($uberMenuDir)) {
                mkdir($uberMenuDir);
            }
            //WP_Filesystem();
            //global $wp_filesystem;
            //$wp_filesystem->put_contents($path, $css);
            file_put_contents($path, $css);
        }
    }

    public function registerContolsStyles()
    {

        wp_enqueue_style('ct_customizer', CT_THEME_DIR_URI . '/theme/plugin/advanced-customizer/assets/css/ctCustomizer.css');
        wp_enqueue_script('ct_customizer_preview ', CT_THEME_DIR_URI . '/theme/plugin/advanced-customizer/assets/js/ctCustomizerPreview.js');
    }

    public function customizerInfo()
    {
        #28876 it broke the header when connected to 'customize_controls_enqueue_scripts'
        $config = array(
            'logoSrc' => CT_THEME_SETTINGS_MAIN_DIR_URI . '/img/createIT_at.png',
            'docsString' => esc_html__('Documentation', 'ct_theme'),
            'docsSrc' => esc_url('http://createit.support/documentation/master/'),
            'imgString' => esc_html__('Browse our portfolio', 'ct_theme'),
            'brandUrl' => 'http://themeforest.net/user/createit-pl/portfolio'
        );
        $config = apply_filters('ct_customizer_brand_config', $config);
        ?>
        <input id="dochref" type="hidden" value="<?php echo esc_url($config['docsSrc']); ?>">
        <input id="docstring" type="hidden" value="<?php echo esc_attr($config['docsString']); ?>">
        <input id="logosrc" type="hidden" value="<?php echo esc_url($config['logoSrc']); ?>">
        <input id="imgtitle" type="hidden" value="<?php echo esc_attr($config['imgString']); ?>">
        <input id="brandurl" type="hidden" value="<?php echo esc_attr($config['brandUrl']); ?>">
        <?php
    }

    /**
     * register custom stylesheets from file
     * hook wp_enqueue_scripts
     */
    public function registerStyles()
    {
        //do not embed compiled styles in preview
        if ($this->isPreview) {
            add_filter('ct_theme_loader.load_styles', '__return_false');

            return;
        }
        $styles = $this->getStylesNames();
        foreach ($styles as $key => $style) {
            $file = $this->getCssDir() . '/' . $style . '.css';
            $fileUrl = $this->getCssUrl() . '/' . $style . '.css';
            if (file_exists($file)) {
                $name = 'ct_theme';
                //ct_theme, ct_theme2 etc.
                if ($key > 0) {
                    $name .= '_' . ($key + 1);
                }
                wp_enqueue_style($name, $fileUrl);
                //unregister default theme styles
            } else {
                if(apply_filters('ct_advanced_customizer.register_styles', true)) {
                    add_action('wp_head', array($this, 'renderCssFromDB'));
                }
            }
        }
        $custom_css = ct_get_option('code_custom_styles_css');
        wp_add_inline_style('ct_theme_3', $custom_css);
        $this->includeFonts();
    }

    /**
     * do we have any custom styles?
     * @return bool
     */
    protected function hasCustomStyles()
    {
        $styles = $this->getStylesNames();
        foreach ($styles as $key => $style) {
            if (file_exists($this->getCssDir() . '/' . $style . '.css') || get_option('ct_customizer_' . $style)) {
                return true;
            }
        }

        return false;
    }

    public function includeFonts()
    {
        $this->fonts = array_unique($this->fonts);
        if (is_array($this->fonts)) {
            foreach ($this->fonts as $key => $font) {
                wp_register_style('customizer_fonts_' . $key, esc_url("http://fonts.googleapis.com/css?family=$font"));
                wp_enqueue_style('customizer_fonts_' . $key);

            }
        }
    }

    //TODO maybe hook upgrader_process_complete
    public function updateAction()
    {
        $vars = get_theme_mods();
        $styles = $this->getStylesNames();
        foreach ($styles as $style) {
            $css = $this->render($style, $vars);
            $this->saveCss($style, $css);
        }
    }

    public function renderCssFromDB()
    {
        esc_url(site_url('/'));
        $styles = $this->getStylesNames();
        foreach ($styles as $style) {

            $css = get_option('ct_customizer_' . $style);
            //wp_add_inline_style( 'customizer_' . $style, $css );
            if ($css) {
                echo '<style id="' . esc_attr('ct_customizer_' . $style) . '" type="text/css">' . $css . '</style>';
            }
        }
        $custom_css = ct_get_option('code_custom_styles_css');
        echo '<style id="' . esc_attr('ct_customizer_' . 'custom') . '" type="text/css">' . $custom_css . '</style>';
    }

    protected function handleAltAttr()
    {
        if (!isset($_POST['customized'])) {
            return;
        }

        $optionSlug = apply_filters('ct_customizer_alt_option_slug', '_alt');
        $imageUploads = new ctDefaultValues('images');
        $imageUploads = apply_filters('ct_customizer_default_values_save', $imageUploads);
        $imageUploads = $imageUploads->imagesArray;
        $customizedOptions = explode(',', str_replace(array('\"', '{', '}'), '', $_POST['customized']));
        foreach ($customizedOptions as $singleItem) {
            $imageOption = explode(':', $singleItem, 2);
            if ($imageOption[1] == '') {
                remove_theme_mod($imageOption[0] . $optionSlug);
                continue;
            }
            if (in_array($imageOption[0], $imageUploads)) {
                global $wpdb;
                $id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s ", $imageOption[1]));
                $attach = get_post($id);
                $alt = get_post_meta($attach->ID, '_wp_attachment_image_alt', true);

                if ($alt) {
                    set_theme_mod($imageOption[0] . $optionSlug, $alt);
                } else {
                    remove_theme_mod($imageOption[0] . $optionSlug);
                }

            }
        }
    }

    /**
     * Compile and add css for save
     *
     * hook customize_save_after
     */
    public function saveAction()
    {

        if (apply_filters('ct_customizer_alt_storing_enabled', true)) {
            $this->handleAltAttr();
        }

        //import new font files;
        $fonts = get_option('ct_customizer_fonts_preview' . THEME_NAME);
        update_option('ct_customizer_fonts' . THEME_NAME, $fonts);
        foreach ($this->styles as $style => $css) {
            $this->saveCss($style, $css);
        }
    }

    public $tempArray = array();

    /**
     * Compile and add css for preview
     * hook customize_preview_init
     */
    public function previewAction()
    {

        $this->isPreview = true;
        $previewFonts = unserialize(get_option('ct_customizer_fonts_preview' . THEME_NAME));
        if (is_array($previewFonts)) {
            $this->fonts = array_merge($this->fonts, $previewFonts);
        }
        add_action('wp_enqueue_scripts', array($this, 'renderInlineCSS'));

    }

    /**
     * echo inline css rendered from less file
     *
     */
    public function renderInlineCSS()
    {
        $stylesToParse = apply_filters('ct_customizer_stylestoparse', $this->getStylesNames());
        foreach ($this->getStylesNames() as $style) {
            if (!in_array($style, $stylesToParse)) {
                //WP_Filesystem();
                //global $wp_filesystem;
                //echo '<style id="' . esc_attr('ct_customizer_' . $style) . '" type="text/css">' . $wp_filesystem->get_contents($this->cssDir . '/' . $style . '.css') . '</style>';
                echo '<style id="' . esc_attr('ct_customizer_' . $style) . '" type="text/css">' . file_get_contents($this->cssDir . '/' . $style . '.css') . '</style>';
            } else {
                if (isset($this->styles[$style])) {
                    //when rendered with new variables
                    $css = $this->styles[$style];
                } elseif (file_exists($this->getCssDir() . '/' . $style . '.css')) {
                    //css from uploads gets highest priority
                    //WP_Filesystem();
                    //global $wp_filesystem;
                    //$css = $wp_filesystem->get_contents($this->getCssUrl() . '/' . $style . '.css');
                    $css = file_get_contents($this->getCssUrl() . '/' . $style . '.css');
                } elseif (file_exists(CT_THEME_DIR . '/assets/css/' . $style . '.css')) {
                    //if not compiled yet
                    //WP_Filesystem();
                    //global $wp_filesystem;
                    //$css = str_replace('../', CT_THEME_ASSETS . '/', $wp_filesystem->get_contents(CT_THEME_ASSETS . '/css/' . $style . '.css'));
                    $css = str_replace('../', CT_THEME_ASSETS . '/', file_get_contents(CT_THEME_ASSETS . '/css/' . $style . '.css'));
                } else {
                    //for development process render less
                    $css = $this->render($style, $this->getVariablesToCompile());
                }
                echo '<style id="' . esc_attr('ct_customizer_' . $style) . '" type="text/css">' . $css . '</style>';
            }
        }
        $custom_css = ct_get_option('code_custom_styles_css');
        echo '<style id="' . esc_attr('ct_customizer_custom') . '" type="text/css">' . $custom_css . '</style>';
    }

    /**
     * Render css file from less files
     *
     * @param string $filename
     * @param array $vars
     * @param array $options
     *
     * @throws exception
     * @return string
     */
    protected function render($filename, $vars = array(), $options = array('compress' => true))
    {
        $path = $this->getLessDir() . '/' . $filename . '.less';

        if (file_exists($path)) {
            //to do filtra
            if (isset($vars['assets-path'])) {
                $uri = str_replace('"', '', $vars['assets-path']);
                $vars['fa-font-path'] = '"' . $uri . 'fonts/font-awesome/fonts/"';
            }

            $vars = apply_filters('ct_customizer.filter_vars', $vars);
            $css = '';
            $fontName = apply_filters('ct_customizer_google_fonts', $fontName = array());
            foreach ($fontName as $singleFont) {
                if (isset($vars[$singleFont])) {
                    $css .= $this->addFonts($vars[$singleFont]);
                }
            }
            try {

                $parser = new Less_Parser($options);
                $parser->parseFile($path);
                $parser->ModifyVars($vars);
                $css .= $parser->getCss();

            } catch (\Exception $e) {
                try {
                    $lessc = new lessc_old($path);
                    $lessc->setPreserveComments(false);
                    $lessc->setVariables($vars);
                    $css .= $lessc->parse();
                } catch (\Exception $e) {
                    $lessc = new lessc($path);
                    $lessc->setPreserveComments(false);
                    $lessc->setVariables($vars);
                    $css .= $lessc->parse(false);

                    echo esc_html($filename) . ' parse error!';
                }
            //echo $e;
            }


        } else {
            $css = '';
        }

        return $css;
    }

    /**
     * Save css in file with name
     *
     * @param $filename
     * @param string $css
     *
     */
    protected function saveCss($filename, $css)
    {

        $dir = $this->getCssDir();
        $path = $dir . '/' . $filename . '.css';
        if ($css != '') {
            if (!file_exists($dir)) {
                if (!mkdir($dir)) {
                    $this->saveCssToDB($filename, $css);

                    return;
                }
            }
            //WP_Filesystem();
            //global  $wp_filesystem;
            //if (false === $wp_filesystem->put_contents($path, $css)) {
            if (false === file_put_contents($path, $css)) {
                $this->saveCssToDB($filename, $css);
            }
        }
    }

    /**
     * @return array
     * @author scyzoryck
     */
    public function getPriorites()
    {
        return $this->priorites;
    }

    /**
     * @param array $priorites
     *
     * @author scyzoryck
     */
    public function setPriorites($priorites)
    {
        $this->priorites = array_merge($this->priorites, $priorites);
    }


    protected function getCssFromDB($filename)
    {
        return get_option('ct_customizer_' . $filename);
    }


    /**
     * Save css in database if can't in file
     *
     * @param string $filename
     * @param string $css
     */
    protected function saveCssToDB($filename, $css)
    {
        update_option('ct_customizer_' . $filename, $css);
    }


    /**
     * Customize theme preview
     *
     * @param WP_Customize_Manager $wp_manager
     *
     * @return \WP_Customize_Manager
     */

    public function customizeRegister($wp_manager)
    {

        do_action('ct_customizer.mapper.pre', $this);
        $this->mapper = new ctControlsMapper($wp_manager,
            $path = $this->getLessDir() . '/' . $this->lessVariables . '.less',
            $this->priorites);

        $this->mapper = apply_filters('ct_customizer_mapper.configure', $this->mapper);


        do_action('ct_customizer_mapper_post', $this->mapper);

        return $wp_manager;
    }

    /**
     * @return string
     * @author scyzoryck
     */
    public function getCssUrl()
    {
        return $this->cssUrl;
    }

    /**
     * @param string $cssUrl
     *
     * @author scyzoryck
     */
    public function setCssUrl($cssUrl = null)
    {
        $uploadData = wp_upload_dir();
        $cssUrl = $uploadData['baseurl'];
        if (is_child_theme()) {
            $theme = wp_get_theme();
            $cssUrl .= '/' . str_replace(' ', '', $theme->name);
        }

        $this->cssUrl = $cssUrl;
    }


    /**
     * returns array with names of styles files (without .css and .less)
     * @return array
     */
    public function getStylesNames()
    {
        return apply_filters('ct_customizer.style_names', $this->stylesNames);
    }

    /**add new name of style (without .css and .less)
     *
     * @param $name
     *
     * @return $this
     */
    public function addStyleName($name)
    {
        $this->stylesNames[] = $name;

        return $this;
    }


    /** remove name of style
     *
     * @param $name
     *
     * @return $this
     */
    public function removeStyleName($name)
    {
        if ($key = array_search($name, $this->stylesNames) !== false) {
            unset($this->stylesNames[$key]);
        }

        return $this;
    }

    public function setStylesNames($styles)
    {
        if (is_array($styles)) {
            $this->stylesNames = $styles;
        }
    }

    /**
     * @return string
     * @author scyzoryck
     */
    public function getLessDir()
    {
        return $this->lessDir;
    }

    /**
     * @param string $lessDir
     *
     * @author scyzoryck
     */
    public function setLessDir($lessDir)
    {
        $this->lessDir = $lessDir;
    }

    /**
     * @return string
     * @author scyzoryck
     */
    public function getCssDir()
    {
        return $this->cssDir;
    }

    /**
     * @param string $cssDir
     *
     * @author scyzoryck
     */
    public function setCssDir($cssDir = null)
    {

        $uploadData = wp_upload_dir();
        $cssDir = $uploadData['basedir'];
        if (is_child_theme()) {
            $theme = wp_get_theme();
            $cssDir .= '/' . str_replace(' ', '', $theme->name);
        }
        $this->cssDir = $cssDir;

    }

    /**
     * @return string
     * @author scyzoryck
     */
    public function getLessVariables()
    {
        return $this->lessVariables;
    }

    /**
     * @param string $lessVariables
     *
     * @author scyzoryck
     */
    public function setLessVariables($lessVariables)
    {
        $this->lessVariables = $lessVariables;
    }

    /**
     * checks if less variable changed
     *
     * @param $customized
     * @return bool
     */
    protected function isLessCustomized($customized)
    {
        if (empty($this->variablesToCompile)) {
            $this->setVariablesToCompile();
        }
        $customized = json_decode(str_replace('\"', '"', $customized), true);
        if (is_array($customized)) {
            foreach ($customized as $key => $variable) {
                if (in_array($key, $this->variablesToCompile)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function getVariablesToCompile()
    {

        if (is_array(get_theme_mods())) {
            $variables = array_filter(get_theme_mods(), 'is_string');
            $variablesChanged = $variablesToCompile = array();
            if (isset($_POST['customized'])) {
                $variablesChanged = json_decode(str_replace('\"', '"', $_POST['customized']), true);
            }
            if (is_array($variablesChanged)) {
                $variables = array_merge($variables, $variablesChanged);
            }
            foreach ($variables as $k => $v) {
                $newKey = ctCustomizerMehods::idToLessname($k);
                if ($newKey !== false) {
                    $variablesToCompile[$newKey] = $v;
                }
            }
            $variablesToCompile = array_merge($variablesToCompile, ctCustomizerMehods::pathVariables());
            return $variablesToCompile;
        }
    }

    public function renderLessToCss($activation = null)
    {
        if (!$activation) {
            foreach (array('wp_customize', 'theme', 'customized') as $param) {
                if (!isset($_POST[$param])) {
                    return;
                }
            }
            //don't compile less if any less variable has changed
            if (!$this->isLessCustomized($_POST['customized'])) {
                return;
            }

        }

        foreach (apply_filters('ct_customizer_stylestoparse', $this->getStylesNames()) as $style) {
            $this->styles[$style] = $this->render($style, $this->getVariablesToCompile());
            //ubermenu support
        }
        if (class_exists('UberMenu')) {
            $this->uberMenu($this->getVariablesToCompile());
        }
    }

    public function addFonts($fontName)
    {
        $fontName = strtr($fontName, array(' ' => '+'));

        return '@import url("http://fonts.googleapis.com/css?family=' . $fontName . '"); ';
    }

}

new ctAdvancedCustomizer();


