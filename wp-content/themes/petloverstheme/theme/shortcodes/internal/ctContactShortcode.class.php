<?php

/**
 * Contact shortcode
 */
class ctContactShortcode extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Contact';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'contact';
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


        $shortcodeContact = '
                <h5 class="text-uppercase ct-fw-600"><i class="fa fa-dot-circle-o"></i> '.$title.'</h5>
                <span class="h3 ct-fw-800"><span class="ct-u-colorDarkerGray">'.$phone_prefix.'</span> '.$phone.'</span>
                <br>
                <span class="text-uppercase ct-fw-600">'.$address.'</span>
                <br>
                <a href="mailto:'.$email.'" class="text-uppercase ct-u-underline ct-fw-600">'.$email_label.'</a>
            ';


        return do_shortcode($shortcodeContact);
    }


    /**
     * Returns config
     *
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => __('GET IN TOUCH', 'ct_theme'), 'type' => 'input'),
            'widgetmode' => array('default' => 'false', 'type' => false),
            'phone_prefix' => array('label' => __('phone prefix', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("enter prefix phone number.", 'ct_theme')),
            'phone' => array('label' => __('phone', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("enter phone number.", 'ct_theme')),
            'email' => array('label' => __('email', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("enter email address.", 'ct_theme')),
            'email_label' => array('label' => __('email label', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("enter email address label.", 'ct_theme')),
            'address' => array('label' => __('address', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('type ' . htmlspecialchars('<br>') . ' to enter the next line', 'ct_theme')),
        );
    }
}

new ctContactShortcode();