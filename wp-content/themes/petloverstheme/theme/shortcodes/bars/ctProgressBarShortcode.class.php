<?php

/**
 * Button shortcode
 */
class ctProgressBarShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Progress bar';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'progress_bar';
    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }

    public function enqueueScripts()
    {
        wp_register_script('ct-progressbars', CT_THEME_ASSETS . '/js/progressbars/init.js', array('jquery'), false, true);
        wp_enqueue_script('ct-progressbars');
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $valuenow = '';
        $valuemin = '';
        $valuemax = '';
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);


        extract($attributes);


        //$this->addInlineJS($this->getInlineJS($attributes), true);
        $mainContainerAtts = array(
            'class' => array(
                'progress-bar animating',


            ),
            'role' => 'progressbar',
            'aria-valuenow' => (int)$percentage,
            'aria-valuemin' => (int)$valuemin,
            'aria-valuemax' => (int)$valuemax,
            ''
        );



        $html = '
                <div class="progress ' . $type . '">
                <style>
                          .progress .progress-bar:after { background-image: url('.$src.');  }
                </style>

                    <div' . $this->buildContainerAttributes($mainContainerAtts, $atts) . ' style="width: ' . $percentage . '%;">
                        <span class="ct-progressBar-text" >' . $percentage . '%  ' . $label . '</span>
                        <div class="ct-progressBar-tr"></div>
                    </div>
                </div>
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
            'type' => array(
                'label' => __('type', 'ct_theme'),
                'default' => 'info',
                'type' => "select",
                'help' => __("Select type of the bar's color", 'ct_theme'),
                'choices' => array(

                    'progress-motive' => __('motive', 'ct_theme'),
                    'progress-success' => __('success', 'ct_theme'),
                    'progress-info' => __('info', 'ct_theme'),
                    'progress-warning' => __('warning', 'ct_theme'),
                    'progress-danger' => __('danger', 'ct_theme'),
                )
            ),
           'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),


        'percentage' => array('label' => __('Percentage', 'ct_theme'), 'type' => "input", 'help' => __("Define how large part of bar should be filled", 'ct_theme')),
            'valuenow' => array('label' => __('Tooltip text', 'ct_theme'), 'type' => "input", 'default' => 0),
            'valuemin' => array('label' => __('Min value', 'ct_theme'), 'type' => "input", 'help' => __("By default Progress Bar starts at 0", 'ct_theme')),
            'valuemax' => array('label' => __('Max value', 'ct_theme'), 'type' => "input", 'default' => 100, 'help' => __("By default Progress Bar maximum value is 100", 'ct_theme')),
            'label' => array('label' => __('Label', 'ct_theme'), 'default' => '', 'type' => 'input'),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-align-left',
        ));
    }
}

new ctProgressBarShortcode();


