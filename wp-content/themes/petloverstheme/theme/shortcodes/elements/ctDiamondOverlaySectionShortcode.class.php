<?php

/**
 * Pricelist shortcode
 */
class ctDiamondOverlaySectionShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Diamond Overlay';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'diamond_overlay';
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
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $dia = CT_THEME_ASSETS . '/images/diamondOverlay.png';
        $html = '
                <div class="ct-diamondOverlay">
                     <img src="' . esc_url($dia) . '" alt="Tropical Aquarium Fishtank">
                         <h3 class="text-center text-uppercase ct-fw-300 animated activate fadeInUp" data-fx="fadeInUp">'.$top.' <span class="ct-fw-500"> '.$title.' </span>  '.$bottom.' </h3>


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
        $items = array();



        $items['title'] = array(
            'label' => __('Title', 'ct_theme'),
            'type' => 'input',
        );

        $items['top'] = array(
            'label' => __('Top subTitle ', 'ct_theme'),
            'type' => 'input',
        );

        $items['bottom'] = array(
            'label' => __('Bottom subTitle ', 'ct_theme'),
            'type' => 'input',
        );


        return $items;

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-caret-square-o-up',
        ));
    }
}

new ctDiamondOverlaySectionShortcode();



