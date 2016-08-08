<?php

/**
 * Image shortcode
 */
class ctImage2Shortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * default image link base
     */
    const DEFAULT_IMG_SRC = "http://dummyimage.com/";

    /**
     * default image width
     */
    const DEFAULT_IMG_WIDTH = 90;

    /**
     * default image heightd
     */
    const DEFAULT_IMG_HEIGHT = 90;

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Image With popUp';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'img2';
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




        $mainContainerAtts = array(
            'class' => array(
                $class,

            ),

        );

        if($size=='large'){
            $size2 = 'ct-u-paddingBottom30 ct-photoGallery-large';
        }else{
            $size2 =' ct-photoGallery-small';
        }

     /*   if ($diamond == 'yes') {
            $dia = CT_THEME_ASSETS . '/images/diamondOverlay.png';
        } else {
            $dia = $seg_img;
        }*/

        if($src2 == ''){
            $imagem = $src;
        }else{
            $imagem = $src2;
        }

        if ($add == 'yes') {
            $a = ' <div class="ct-imageOverlay-container">
                        <div class="ct-imageButton"></div>
                        <div class="ct-imageOverlay ct-img100">
                            <div class="ct-imageOverlay-text">
                                <h3 class="text-center text-uppercase ct-fw-300">' . $top_subtitle . '</h3>
                                <h3 class="text-center text-uppercase ct-fw-300"><span class="ct-fw-500">' . $title . '</span></h3>
                                <h3 class="text-center text-uppercase ct-fw-300">' . $bottom_subtitle . '</h3>
                            </div>
                        </div>
                        <img src="' . esc_url($src) . '" alt="' . $alt . '">
                    </div>

        ';
        } else {

            $a = '  <div class="ct-imageOverlay-container ct-u-marginBottom30 animated activate flipInX" data-fx="flipInX" data-time="250">
                                <div class="ct-imageButton"></div>
                                <img src="' . esc_url($src) . '" alt="' . $alt . '">
                            </div>

        ';
        }


        $html = '<div class=" '.$size2.'">
                <a href="' . esc_url($imagem) . '" class="ct-js-magnificPopupImage">
                    '.$a.'
                </a>
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
        return array(

            'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),

            'src2' => array('label' => __("Big Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),

            'size' => array('label' => __('Size', 'ct_theme'), 'default' => 'normal',
                'type' => 'select',
                'choices' => array('large' => 'large', 'normal' => 'normal'),
            ),


            'add' => array('label' => __('Add content', 'ct_theme'), 'default' => 'no',
                'type' => 'select',
                'choices' => array('yes' => 'yes', 'no' => 'no'),
                'dependency' => array(
                    'element' => 'size',
                    'value' => 'large')
            ),

            'diamond' => array('label' => __('diamond', 'ct_theme'), 'default' => 'yes',
                'type' => 'select',
                'choices' => array('yes' => 'yes', 'no' => 'no'),
                'dependency' => array(
                    'element' => 'add',
                    'value' => 'yes')
            ),

            'seg_img' => array('label' => __('Image overlay', 'ct_theme'), 'default' => '', 'type' => 'image',
                'dependency' => array(
                    'element' => 'diamond',
                    'value' => 'no')
            ),


            'title' => array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),


            'top_subtitle' => array('label' => __('Top subtitle', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),


            'bottom_subtitle' => array('label' => __('Bottom subtitle', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'add',
                    'value' => array('yes'))
            ),



            'alt' => array('label' => __('alt', 'ct_theme'), 'default' => ' ', 'type' => 'input', 'help' => __("Alternate text", 'ct_theme')),


            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    /**
     * returns default image source
     * @param $width
     * @param $height
     * @return string
     */
    protected function getDefaultImgSrc($width, $height)
    {
        if ($width && $height) {
            return self::DEFAULT_IMG_SRC . $width . "x" . $height;
        }
        return '';
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-picture-o',
	        'description' => __( "Add an image", 'ct_theme')
	        ));
    }
}

new ctImage2Shortcode();