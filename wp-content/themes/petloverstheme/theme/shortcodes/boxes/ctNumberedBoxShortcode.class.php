<?php

/**
 * Pricelist shortcode
 */
class ctNumberedBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Number box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'number_box';
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


$ani='';

        if($animation == 'yes'){
        $ani = ' <div class="ct-line ct-line--1 animated activate bounceInLeft ct-show" data-fx="bounceInLeft ct-show" data-time="0"></div>
                        <div class="ct-line ct-line--2 animated activate bounceInLeft ct-show" data-fx="bounceInLeft ct-show" data-time="250"></div>
                        <div class="ct-line ct-line--3 animated activate bounceInLeft ct-show" data-fx="bounceInLeft ct-show" data-time="500"></div>';

        }


        $html = '
                   <div class="ct-numberedBox ct-u-paddingBottom60">
                    <div class="ct-numberedBox-head">
                       '.$ani.'
                      <h2 class="ct-fw-300 ct-u-positionRelative"><span class=""> '.$number.'</span></h2>
                    </div>
                   <h4 class="ct-fw-400">'.$title.'</h4>
                    <p class="ct-u-paddingBottom20">'.$content.'</p>
                   '.$buttonHtml.'
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


        $items['number'] = array(
            'label' => __('number', 'ct_theme'),
            'default' => '',
            'type' => 'input',

        );

        $items['title'] = array(
            'label' => __('title', 'ct_theme'),
            'default' => '',
            'type' => 'input',

        );
        $items['animation'] = array(
            'label' => __('underlined', 'ct_theme'),
            'default' => 'yes',
            'type' => 'select',
            'choices' => array(
                'yes' => 'yes',
                'no' => 'no'),

        );

        /*$items[$this->getParamNameFromNamespace('rel_format1_content', 'header')] = array(
            'group' => '',
            'type' => 'input',
            'label' => __('Title', 'ct_theme'),
        );*/

        $items['content'] = array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea");
        //Stamdard params
        //$items['link'] = array('label' => __('Link', 'ct_theme'), 'default' => '', 'type' => 'input');

        $items['new_window'] = array('label' => __('Open link in new Window?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')));
        $items['class'] = array('label' => __("Custom class", 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')
        );

        //add related header attributes






        //merge with related icon
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
        ) );
    }
}

new ctNumberedBoxShortcode();



