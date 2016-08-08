<?php

/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 2015-01-26
 * Time: 15:09
 */
class ctWpmlPlugin
{

    public function __contruct()
    {
        add_filter('body_class', array($this, 'addBodyClass'), 11, 2);
    }


    public function addBodyClass($classes)
    {
        if (function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE')) {
            $classes[] = ICL_LANGUAGE_CODE;
        }

        if (function_exists('ct_is_woocommerce_active') && ct_is_woocommerce_active()) {
            $classes[] = 'ct-woocommerceActive';
        }


        return $classes;
    }

}

new ctWpmlPlugin();