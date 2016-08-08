<?php

if (!class_exists('WP_Customize_Control')) {
    return null;
}

/**
 * A class to create a dropdown for all google fonts
 */
class ctPostDropdownControl extends WP_Customize_Control implements ctControlsFilterableInterface
{
    private $fonts = false;

    private $selectId;
    public $postType;
    public $posts;
    public $fontlink;


    public function __construct($manager, $id, $options = array())
    {
        $this->postType = isset($options['post_type']) ? $options['post_type'] : 'gallery';
        $postargs = wp_parse_args(array('numberposts' => '-1', 'post_type' =>  $this->postType, 'post_status'=>'publish'));
        $this->posts = get_posts($postargs);
        parent::__construct($manager, $id, $options);
    }


    /**
     * Render the content of the category dropdown
     *
     * @return string
     */
    public function render_content()
    {
        $default = esc_html__('Default', 'ct_theme');
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <select id="customizer_posts_<?php echo esc_attr($this->selectId) ?>" <?php $this->link(); ?>
                        data-default-value="<?php echo esc_attr($this->setting->default) ?>">
                    <?php
                    foreach ($this->posts as $post) {
                            printf('<option  value="%s" %s >%s</option>',
                            $post->ID,
                            selected($post->ID, $this->value(), false),
                            $post->post_title);
                    }

                    printf('<option  value="%s" %s >%s</option>',
                        '',
                        selected('', $this->value(), false),
                        '');

                    ?>
                </select>
                <input class="button ct-default" type="button" value="<?php echo esc_attr($default) ?>">
            </label>
        <?php
    }

    public function enqueue()
    {
        wp_enqueue_script('ct-default-value',
            CT_THEME_DIR_URI . '/theme/plugin/advanced-customizer/assets/js/ctDefaultValue.js',
            array('jquery'));
    }

    public static function family_to_value($name)
    {
        echo esc_html($name);

        return str_replace(' ', '+', $name);
    }


    public function get_static_fonts()
    {
        $staticFontFile = CT_ADVANCED_CUSTOMIZER_PATH . '/controls/google-web-fonts.json';

        //WP_Filesystem();
        //global $wp_filesystem; // $wp_filesystem->get_contents
        //$json = $wp_filesystem->get_contents($staticFontFile);
        $json = file_get_contents($staticFontFile);
        $content = json_decode($json);

        return $content;
    }

    /**
     * Get the google fonts from the API or in the cache
     *
     * @param  integer|string $amount
     *
     * @return String
     */
    public function get_fonts($amount = 50)
    {
        $baseUploadDir = wp_upload_dir();
        $uploadDir = $baseUploadDir['basedir'];
        $cacheDir = $uploadDir . '/cache';
        $content = array();

        $fontFile = $cacheDir . '/google-web-fonts.json';

        //Total time the file will be cached in seconds, set to a week
        $cachetime = 86400 * 7;

        if (file_exists($fontFile) && time() - $cachetime < filemtime($fontFile)) {
            //cache exist
            //WP_Filesystem();
            //global $wp_filesystem; // $wp_filesystem->get_contents
            //$content = json_decode($wp_filesystem->get_contents($fontFile));
            $content = json_decode(file_get_contents($fontFile));
        } else {
            //get from googleapis
            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=' . 'AIzaSyBmPRa5TGlBRbUUV-pVPU3GxXRkD4lBtUU';
            $fontContent = wp_remote_get($googleApi, array('sslverify' => false));


            if (!file_exists($cacheDir)) {
                //make dir for cache
                if (mkdir($cacheDir)) {
                    //try to save cache
                    //WP_Filesystem();
                    //global  $wp_filesystem;
                    //$wp_filesystem->put_contents($fontFile, $fontContent['body']);
                    file_put_contents($fontFile, $fontContent['body']);
                }
            }

            if (!is_wp_error($fontContent)) {
                //cannot conect with googleapi (WP_ERROR)
                $content = $this->get_static_fonts();
            } else {
                $content = json_decode($fontContent['body']);
            }
        }

        if (isset($content->error)) {
            //error with getting fonts from googleapi
            $content = $this->get_static_fonts();
        }

        if ($amount == 'all') {
            return $content->items;
        } else {
            return array_slice($content->items, 0, $amount);
        }
    }

    /** Filter value from form, add validation, saving to database prefix, suffix ect.
     *
     * @param string $val value from form
     *
     * @return mixed filtred $val
     */
    public function filter($val)
    {
        $lessname = $this->selectId;
        $fonts = unserialize(get_site_option('ct_customizer_fonts_preview' . THEME_NAME));
        $fonts = is_array($fonts) ? $fonts : array();

        $fontlink = str_replace(' ', '+', $val);

        if (($subset = get_theme_mod($this->lessnameToId($lessname . 'set'))) !== false) {
            $fontlink .= '&amp;subset=' . $subset;
        }
        $fonts[$lessname] = $fontlink;
        $fonts = serialize($fonts);

        wp_register_style('customizer_fonts_' . $fontlink, esc_url("http://fonts.googleapis.com/css?family={$fontlink}"));
        wp_enqueue_style('customizer_fonts_' . $fontlink);


        update_site_option('ct_customizer_fonts_preview' . THEME_NAME, $fonts);

        return '"' . $val . '", sans-serif';
    }


    protected function lessnameToId($name)
    {
        $id = 'ct_customizer_' . str_replace('-', '_', $name);

        return $id;
    }

}

?>