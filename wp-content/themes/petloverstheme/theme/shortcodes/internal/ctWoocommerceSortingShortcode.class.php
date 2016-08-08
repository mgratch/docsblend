<?php

/**
 * Pricelist shortcode
 */
class ctSortingShortcode extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Sorting';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_sorting';
    }

    /**
     * Returns shortcode type
     * @return mixed|string
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

        if (!ct_is_woocommerce_active()) {
            return;
        }




        ob_start();
        woocommerce_catalog_ordering();
        return '<h4 class="color-motive uppercase">' . $title . '</h4>' . ob_get_clean() . '
                            <div class="clearfix"></div>';
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
         );
    }


}

new ctSortingShortcode();



