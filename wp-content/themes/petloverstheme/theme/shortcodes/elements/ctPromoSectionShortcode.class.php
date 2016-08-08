<?php

/**
 * Pricelist shortcode
 */
class ctPromoSectionShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Promo Section';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'promo_section';
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

        $buttonHtml = $this->buildRelatedShortcode('button', $atts, 'button_rel');

        $alt = '';

        if (strpos($number, ',') !== false) {
            $number2 = explode(',', $number);

            $print = '<h2><span>' . $number2[0] . '</span> ' . $number2[1] . '</h2>';
        } else {
            $print = ' <h2>' . $number . '</h2>';
        }


        if (strpos($title, '/') !== false) {
            $title2 = explode('/', $title);

            $print2 = '<h4 class="ct-fw-300 ct-u-marginBottom0">' . $title2[0] . '<span> ' . $title2[1] . '</span></h4>';
        } else {
            $print2 = ' <h4 class="ct-fw-300 ct-u-marginBottom0">' . $title . '</h4>';
        }

        $html = '
                   <section class="ct-promoSection ct-u-paddingBottom100">
                         <div class="container">
                                <img class="ct-u-paddingBoth30" src="' . esc_url($bg_image) . '" alt="' . $alt . '">
                                <div class="ct-pageSectionHeader ct-fw-300">
                                   ' . $print2 . '
                                   ' . $print . '
                                   ' . $buttonHtml . '
                                </div>
                         </div>
                    </section>
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

        $items['bg_image'] = array('label' => __("Background Image", 'ct_theme'), 'default' => '',
            'type' => 'image',
        );

        $items['number'] = array(
            'label' => __('Number (separate with comma)', 'ct_theme'),
            'type' => 'input',
        );

        $items['title'] = array(
            'label' => __('Title  (add / if you want black and blue font color', 'ct_theme'),
            'type' => 'input',
        );


        return $this->mergeShortcodeAttributes($items, 'button', 'button_rel', __('Button', 'ct_theme'));

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

new ctPromoSectionShortcode();



