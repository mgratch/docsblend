<?php

/**
 * Pricelist shortcode
 */
class ctIconBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Icon box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'icon_box';
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



        //$atts['header_rel_format2_class'] = 'ct-iconBox-title';
    //    $atts['header_rel_format1_class'] = 'ct-iconBox-title';


        $iconHtml = $this->buildRelatedShortcode('icon', $atts, 'icon_rel');



        // <h4 class="ct-iconBox-title text-lowercase ct-fw-600">
            $html = '
                    <div class="ct-iconBox '.$icon_box_color.' '.$icon_side.'">
                        '.$iconHtml.'
                        <h4 class="text-uppercase ct-fw-600 ct-u-size18">'.$header.'</h4>
                        <p>'.$content.'</p>
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


        $items['icon_side'] = array(
            'label' => __('Icon side', 'ct_theme'),
            'default' => 'ct-iconBox--leftIcon',
            'type' => 'select',
            'options' => array(
                'ct-iconBox--leftIcon' => 'left icon',
                'ct-iconBox--rightIcon' => 'right icon'),
        'dependency' => array(
            'element'=> 'type',
            'value' => array('ct-iconBox')
        )
    );
        $items['icon_box_color'] = array(
            'label' => __('Icon box color', 'ct_theme'),
            'default' => 'ct-iconBox--leftIcon',
            'type' => 'select',
            'options' => array(
                '' => 'Default',
                'ct-iconBox-motive' => 'Motive'),
            'dependency' => array(
                'element'=> 'type',
                'value' => array('ct-iconBox')
            )
        );


        //merge from related HEADER->FORMAT1->CONTENT
        $items['header'] = array(
            'label' => __('Icon Box header', 'ct_theme'),
           // 'group' => '',
            'type' => 'input',

        );

        $items['content'] = array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea");

        //Stamdard params
      //  $items['link'] = array('label' => __('Link', 'ct_theme'), 'default' => '', 'type' => 'input');

        $items['new_window'] = array('label' => __('Open link in new Window?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')));
        $items['class'] = array('label' => __("Custom class", 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')
        );

        //add related header attributes




        //merge with related icon
       return $this->mergeShortcodeAttributes($items, 'icon', 'icon_rel', __('Icon', 'ct_theme'));

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-caret-square-o-up',
        ) );
    }
}

new ctIconBoxShortcode();



