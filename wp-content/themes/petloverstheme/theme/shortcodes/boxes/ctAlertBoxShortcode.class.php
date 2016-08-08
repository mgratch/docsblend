<?php

/**
 * Alert Box shortcode
 */
class ctAlertBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Alert Box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'alert_box';
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


        $bt = '';
        switch ($type) {


            case 'alert-danger':
                $bt = 'btn-danger';
                break;
            case   'alert-success':
                $bt = 'btn-success';
                break;
            case   'alert-info':
                $bt = 'btn-info';
                break;
            case   'alert-warning':
                $bt = 'btn-warning';
        }

        $btn = '';

        if ($bt_label != '') {
            $btn = '<a class="btn ' . $bt . ' ct-u-marginTop10"><span> ' . $bt_label . ' </span></a>';
        }

        if ($size == 'default') {
            $html = '<div class="alert ' . $type . '" role="alert">
                <strong>' . $title . '</strong>&nbsp;&nbsp;' . $content . '
            </div>';
        } else {
            $html = '
            <div class="alert ' . $type . '" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
                <span class="sr-only">' . __('Close', 'ct_theme') . '</span></button>
                <strong>' . $title . '</strong>
                <p>' . $content . '</p>
                    ' . $btn . '
            </div>


            ';

        }


        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'size' => array(
                'label' => __('Size', 'ct_theme'),
                'default' => 'default',
                'type' => "select",
                'help' => __("Select size of the box color", 'ct_theme'),
                'choices' => array(
                    'default' => __('default', 'ct_theme'),
                    'big' => __('big', 'ct_theme'),
                )
            ),

            'type' => array(
                'label' => __('type', 'ct_theme'),
                'default' => 'info',
                'type' => "select",
                'help' => __("Select type of the box color", 'ct_theme'),
                'choices' => array(
                    'alert-danger' => __('danger', 'ct_theme'),
                    'alert-success' => __('success', 'ct_theme'),
                    'alert-info' => __('info', 'ct_theme'),
                    'alert-warning' => __('warning', 'ct_theme'),
                )
            ),

            'title' => array(
                'label' => __('title', 'ct_theme'),
                'default' => '',
                'type' => 'input',
            ),

            'bt_label' => array(
                'label' => __('button label', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'dependency' => array(
                    'element'=> 'size',
                    'value' => array('big')
                )
            ),


            'content' => array('label' => __('Message', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'id' => array('type' => false, 'default' => ''),
            'class' => array('label' => __("Custom CSS class", 'ct_theme'))
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-exclamation-triangle',
            'description' => __("Custom alert box", 'ct_theme')
        ));
    }
}

new ctAlertBoxShortcode();