<?php

/**
 * Button shortcode
 */
class ctButtonShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Button';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'button';
    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
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
        $iconHtml = $this->buildRelatedShortcode('icon', $atts, 'icon_rel');


        if ($autolink == 'blog') {
            $link = get_permalink(get_option('page_for_posts'));
        }

        if ($autolink == 'portfolio') {
            $link = get_post_type_archive_link('portfolio');
        }


        if ($open_new_tab == 'yes') {
            $tab = 'target="_blank"';
        } else
            $tab = '';


        if ($type == 'normal') {
            $mainContainerAtts = array(
                'class' => array(
                    'btn',
                    $size,
                    $style,
                    $class,
                    $disabled,
                ),
            //'href' => esc_url($link)
            );

            if ($id) {
                $mainContainerAtts['id'] = $id;
            }

            $ButtonHtml = '<a href="' . $link . '" role="button" ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '' . $tab . '><span>' . $content . '</span>' . $iconHtml . '</a>';
        } else {
            $mainContainerAtts = array(
                'class' => array(
                    'btn',
                    $shape,
                    $shape . '-' . $size2,
                    $style,
                    $class,
                    $disabled,

                ),
            //'href' => esc_url($link)
            );


            $ButtonHtml = '<a href="' . $link . '"' . $this->buildContainerAttributes($mainContainerAtts, $atts) . 'target="_blank">' . $iconHtml . '</a>';
        }


        return do_shortcode($ButtonHtml);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {

        $items = array(

            'id' => array('default' => false, 'type' => false),

            'type' => array('label' => __('Type', 'ct_theme'), 'default' => 'normal', 'type' => 'select', 'choices' =>
                array(
                    'normal' => __('normal', 'ct_theme'),
                    'simple_icon' => __('simple icon', 'ct_theme'),
                )),


            'shape' => array('label' => __('Shape', 'ct_theme'), 'default' => 'ct-diamondButton', 'type' => 'select',
                'choices' => array(
                    'ct-diamondButton' => __('diamond', 'ct_theme'),
                    'ct-squareButton' => __('square', 'ct_theme')),
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('simple_icon')
                )
            ),


            'size' => array('label' => __('Size', 'ct_theme'), 'default' => 'normal', 'type' => 'select', 'choices' =>
                array(
                    'btn-xs' => __('very small', 'ct_theme'),
                    'btn-sm' => __('small', 'ct_theme'),
                    'normal' => __('normal', 'ct_theme'),
                    'btn-lg' => __('large', 'ct_theme')),
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('normal')
                )
            ),


            'size2' => array('label' => __('Size', 'ct_theme'), 'default' => 'normal', 'type' => 'select', 'choices' =>
                array(
                    'xs' => __('very small', 'ct_theme'),
                    'sm' => __('small', 'ct_theme'),
                    '' => __('normal', 'ct_theme'),
                    'lg' => __('large', 'ct_theme')),
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('simple_icon')
                )
            ),


            'style' => array('label' => __('Style', 'ct_theme'), 'default' => 'btn-motive', 'type' => 'select', 'choices' =>
                array(
                    'btn-motive' => __('motive', 'ct_theme'),
                    'btn-motiveDark' => __('motiveDark', 'ct_theme'),
                    'btn-success' => __('success', 'ct_theme'),
                    'btn-danger' => __('danger', 'ct_theme'),
                    'btn-info' => __('info', 'ct_theme'),
                    'btn-warning' => __('warning', 'ct_theme'),
                    'btn-gray' => __('gray', 'ct_theme'),
                ),
                'help' => __("Button style", 'ct_theme')
            ),
            'disabled' => array(
                'label' => __("Disabled", 'ct_theme'),
                'type' => 'checkbox',
                'default' => '',
                'value' => 'disabled',
            ),

            'autolink' => array('label' => __('Autolink', 'ct_theme'), 'default' => '', 'type' => 'select', 'choices' =>
                array(
                    'none' => __('none', 'ct_theme'),
                    'blog' => __('blog index', 'ct_theme'),
                    'portfolio' => __('portfolio', 'ct_theme'),
                ), 'help' => __("ex. link to index blog or portfolio", 'ct_theme'),
            ),

            'link' => array('label' => __('Link', 'ct_theme'), 'help' => __("ex. http://www.google.com", 'ct_theme'), 'dependency' => array(
                'element' => 'autolink',
                'value' => array('none')
            )),


            'open_new_tab' => array('label' => __('Open on new tab', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' =>
                array(
                    'no' => __('no', 'ct_theme'),
                    'yes' => __('yes', 'ct_theme'),
                )),


            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '',
                'type' => 'textarea',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('normal')
                )
            ),


            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
        return $this->mergeShortcodeAttributes($items, 'icon', 'icon_rel', __('Icon', 'ct_theme'));
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-plus-square',
        ));
    }
}

new ctButtonShortcode();