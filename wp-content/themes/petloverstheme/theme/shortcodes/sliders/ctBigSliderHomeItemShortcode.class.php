<?php

/**
 * Big Slider Item shortcode
 */
class ctBigSliderHomeItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Big Slider Item';
    }

    /**
     * Parent shortcode name
     * @return null
     */
    public function getParentShortcodeName()
    {
        return 'ct_big_slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_big_slider_home_item';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $mainContainerAtts = array(
            'class' => array(
                $class
            ),
            'data-bg' => $bg_image,
        );


        if ($diamond == 'yes') {
            $dia = CT_THEME_ASSETS . '/images/diamondOverlay.png';
        } else {
            $dia = $seg_img;
        }


        if ($add == 'yes') {
            $ctx = '<div class="inner">
                <img style="width:auto;" src="' . esc_url($dia) . '" alt="'.$title.'">
                <h3 class="text-center text-uppercase ct-fw-300 animated fadeInUp activate" data-fx="fadeInUp"> ' . $top_subtitle . '<span class="ct-fw-500">' . $title . '</span> ' . $bottom_subtitle . '</h3>
            </div>
            ';
        } else {
            $ctx = '';
        }


        $html =
            '


        <li' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
               ' . $ctx . '
            </li>
        ';
        return do_shortcode($html);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {

        return array(


            'bg_image' => array('label' => __("Background Image", 'ct_theme'), 'default' => '',
                'type' => 'image'),


            'add' => array('label' => __('Add content', 'ct_theme'), 'default' => 'no',
                'type' => 'select',
                'choices' => array('yes' => 'yes', 'no' => 'no'),
            ),

            'diamond' => array('label' => __('diamond', 'ct_theme'), 'default' => 'yes',
                'type' => 'select',
                'choices' => array('yes' => 'yes', 'no' => 'no'),
                'dependency' => array(
                    'element' => 'add',
                    'value' => 'yes')
            ),

            'seg_img' => array('label' => __('Image overlay', 'ct_theme'), 'default' => '', 'type' => 'image',
                'dependency' => array(
                    'element' => 'diamond',
                    'value' => 'no')
            ),


            'title' => array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),


            'top_subtitle' => array('label' => __('Top subtitle', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),


            'bottom_subtitle' => array('label' => __('Bottom subtitle', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),

            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-picture-o',
            'container' => false,
            'description' => __("Add a child element of the slider", 'ct_theme')
        ));
    }
}

new ctBigSliderHomeItemShortcode();