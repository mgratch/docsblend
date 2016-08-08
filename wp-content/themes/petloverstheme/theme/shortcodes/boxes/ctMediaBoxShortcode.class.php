<?php

/**
 * Pricelist shortcode
 */
class ctMediaBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Media box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'media_box';
    }

    /**
     * Returns shortcode type
     * @return mixed|string
     */

    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }



    public function enqueueScripts() {
        wp_register_script( 'jquery.magnific-popup.min', CT_THEME_ASSETS . '/js/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'ct-js-magnificPopup' );

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



        $atts['header_rel_format2_class'] = 'ct-iconBox-title';
    //    $atts['header_rel_format1_class'] = 'ct-iconBox-title';


     //   $headerHtml = $this->buildRelatedShortcode('header', $atts, 'header_rel');
        // <h4 class="ct-iconBox-title text-lowercase ct-fw-600">


        switch ($type) {
            default:
            case 'ct-mediaBox':

                if ($type2 == 'video') { //media-video

                    $html = '
<!--media-video-->
                    <div class="ct-mediaBox">
                    <a href="'.$video_src.'" class="ct-js-magnificPopupMedia">
                     <video muted class="ct-js-video" src="'.$video_src.'"></video>
                      </a>
                   <!--<img src="assets/images/demo-content/FreshVideoImage01.png">-->
                    </div>

                    ';

                } else {  //media-image
                    $html =        '

<!--media-image-->
                                    <div class="ct-mediaBox">
                                        <a href="'.$src.'" class="ct-js-magnificPopupImage">
                                            <img src="'.$src.'" alt="">
                                        </a>
                                    </div>
                        ';

                }
                break;

            case 'ct-mediaBox--text':
                if ($type2 == 'video') {
                    $html = '

<!--box-video-->
                                    <div class="ct-mediaBox ct-mediaBox--text">
                                       <h'.$level.' class="text-uppercase">'.$header.'</h'.$level.'>
                                        <a href="'.$video_src.'" class="ct-js-magnificPopupMedia"><span>'.$link_text.'</span></a>
                                    </div>
                    ';
                } else {

                    $html = '

<!--box-image-->
                                    <div class="ct-mediaBox ct-mediaBox--text">
                                        <h'.$level.' class="text-uppercase">'.$header.'</h'.$level.'>
                                        <a href="'.$src.'" class="ct-js-magnificPopupImage"><span>'.$link_text.'</span></a>
                                    </div>
                    ';
                }
                break;
        }

        return do_shortcode($html);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $items = array();

        $items['type'] = array(
            'label' => __('type', 'ct_theme'),
            'default' => '',
            'type' => 'select',
            'options' => array(
                'ct-mediaBox'        => 'Media',
                'ct-mediaBox--text' => 'Text'),

    );

        $items['type2'] = array(
            'label' => __('type', 'ct_theme'),
            'default' => 'ct-iconBox--leftIcon',
            'type' => 'select',
            'options' => array(
                'video' => 'video',
                'image' => 'image'),
            'dependency' => array(
                'element'=> 'type',
                'value' => array('ct-mediaBox','ct-mediaBox--text' )
            )
        );

        $items['src'] = array(
            'label' => __("image", 'ct_theme'),
            'default' => '', 'type' => 'image',
            'help' => __("Image source", 'ct_theme'),
            'dependency' => array(
                'element' => 'type2',
                'value' => array('image')
            )
        );


        $items['video_src'] = array(
            'label' => __("video", 'ct_theme'),
            'default' => '', 'type' => 'input',
            'help' => __("video source", 'ct_theme'),
            'dependency' => array(
                'element' => 'type2',
                'value' => array('video')
            )
        );


        $items['link_text'] = array(
            'label' => __("link_text", 'ct_theme'),
            'default' => 'view', 'type' => 'input',
            'help' => __("video source", 'ct_theme'),
            'dependency' => array(
                'element' => 'type',
                'value' => array('ct-mediaBox--text')
            )
        );

       /* $items['link'] = array(
            'label' => __('Link', 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'dependency' => array(
                'element'=> 'type',
                'value' => array('ct-mediaBox--text')
            )
        );*/

        $items['header'] = array(
            'type' => 'input',
            'label' => __('Box header', 'ct_theme'),
            'dependency' => array(
                'element'=> 'type',
                'value' => array('ct-mediaBox--text')
            )
        );

        $items ['level'] = array(
            'label' => __('Header level (1-6)', 'ct_theme'),
            'default' => '4',
            'type' => 'select',
            'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            'dependency' => array(
                'element'=> 'type',
                'value' => array('ct-mediaBox--text')
            )
        );
        //merge from related HEADER->FORMAT1->CONTENT
       /* $items[$this->getParamNameFromNamespace('rel_format1_content', 'header')] = array(
            'group' => '',
            'type' => 'input',
            'label' => __('Icon Box header', 'ct_theme'),
        );*/

      //  $items['content'] = array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea");

        //Stamdard params

        $items['class'] = array('label' => __("Custom class", 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')
        );

        //add related header attributes
   /*     return $this->mergeShortcodeAttributes($items, 'header', 'header_rel', __('Header', 'ct_theme')
        );*/
return $items;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-caret-square-o-right',
        ) );
    }
}

new ctMediaBoxShortcode();



