<?php

/**
 * Pricelist shortcode
 */
class ctCartShortcode extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Cart';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_cart';
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


        global $woocommerce;
        $basketTotal = $woocommerce->cart->get_cart_total();
        $basketCounter = sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'ct_theme'), $woocommerce->cart->cart_contents_count);



        $html = '

        <nav>
                            <ul>
                                <li>';
        if (is_user_logged_in()) {
            $html .= '<a href="' . wp_logout_url() . '">' . __('Logout', 'ct_theme') . '</a>';
        } else {
            $html .= '<a href="' . get_permalink(woocommerce_get_page_id('myaccount')) .'">'. __('Login / Register', 'ct_theme') . '</a>';
        }
        $html .= '</li>
                            </ul>
                        </nav>
                        <div class="ct-cart">
                            <a href="' . esc_url($woocommerce->cart->get_cart_url()) . '"
                               title="' . __('View your shopping cart', 'woothemes') . '">
                                <i class="fa fa-fw fa-2x fa-shopping-cart"></i>
                                <span class="cart-numbers"><span
                                        class="number-items">' . $basketCounter . '</span> &boxh; <span
                                        class="items-total">' . $basketTotal . '</span>
                            </a></div>


        ';


        return '<h4 class="color-motive uppercase">' . $title . '</h4>' . $html;
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

new ctCartShortcode();



