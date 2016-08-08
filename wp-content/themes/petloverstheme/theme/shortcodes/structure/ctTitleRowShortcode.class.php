<?php

/**
 * Title row shortcode
 */
class ctTitleRowShortcode extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Title row';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'title_row';
    }

    /**
     *
     */

    public function enqueueScripts()
    {

    }


    /**
     * Handles shortcode
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        //modifiers
        $mainContainerAtts['class'] = array($color_bar, $size_bar);
        $mainContainerAtts['data-stellar-background-ratio'] = floatval(ct_get_context_option('pages_header_parallax_ratio', 0.5));
        $mainContainerAtts['data-type'] = 'parallax';
        $mainContainerAtts['data-bg-image'] = ct_get_context_option('pages_header_image');
        $mainContainerAtts['data-bg-image-mobile'] = ct_get_context_option('pages_header_image_mobile');




        if (ct_get_context_option('pages_show_bar') == 'no') {
            $html = '';
        }

        else {

            $headerContainerAtts['class'] = array(
                '',

                $color = ct_get_context_option('pages_color_bar', 'ct-breadcrumb--motive'),
                ct_get_context_option('pages_size_bar'),


             //   var_dump(ct_get_context_option('show_title_row'))
                // ct_get_context_option('show_breadcrumbs'),


            );

            //  echo  ct_get_breadcrumbs_html();


            $html = '<header' . $this->buildContainerAttributes($headerContainerAtts, $atts, 'header') . '>

                        <div class="container ct-breadcrumb ' . $color . '">
                         ' . ct_get_breadcrumbs_html() . '
                                <span class="ct-breadcrumb-title ct-breadcrumb--white">' . $header . '</span>
    </div>
                    </header>';


        }


        return $html;


    }


    /**
     * is template with sidebar?
     * @return bool
     */
    protected function isSidebar()
    {
        return is_page_template('page-custom.php') || is_page_template('page-custom-left.php');
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'id' => array(
                'label' => __('header id', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("html id attribute", 'ct_theme')
            ),


            'show_bar' => array(
                'label' => __('Breadcrumbs', 'ct_theme'),
                'default' => '',
                'type' => 'select',
                'options' => array(
                    '1' => 'yes',
                    '2' => 'no')),

            'header' => array(
                'label' => __('header', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Header text", 'ct_theme')
            ),
            'breadcrumbs_' => array(
                'label' => __('breadcrumbs', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("breadcrumbs text", 'ct_theme')
            ),

            'breadcrumbs' => array(
                'label' => __('Breadcrumbs', 'ct_theme'),
                'default' => '',
                'type' => 'select',
                'options' => array(
                    '1' => 'yes',
                    '2' => 'no')),

            'color_bar' => array(
                'label' => __('Color', 'ct_theme'),
                'default' => '',
                'type' => 'select',
                'options' => array(
                    'ct-breadcrumb--motive' => 'motive',
                    'ct-breadcrumb--motiveLight' => 'motive light',
                    'ct-breadcrumb--motiveDark' => 'motive dark',
                    'ct-breadcrumb--default' => 'default',
                    'ct-breadcrumb--primary' => 'primary',
                    'ct-breadcrumb--info' => 'info',
                    'ct-breadcrumb--warning' => 'warning',
                    'ct-breadcrumb--danger' => 'danger')),


            'size_bar' => array(
                'label' => __('Breadcrumbs', 'ct_theme'),
                'default' => '',
                'type' => 'select',
                'options' => array(
                    '' => 'Default',
                    'ct-breadcrumb--small' => 'Small')),
        );
    }
}

new ctTitleRowShortcode();



