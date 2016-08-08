<?php

/**
 * Pricelist shortcode
 */
class ctPersonBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Person box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'person_box';
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

        $arr = $atts;


        $mainContainerAtts = array(
            'class' => array(
                'ct-teamMember',

                $class,

            )
        );


        if($type =='1'){
            $html =' <a href="'.$link.'">
                    <img src="' . esc_url($image) . '" alt="' . esc_attr($name) . '">
                    <div class="ct-teamMember--bg ct-u-paddingBoth20">
                        <p class="text-uppercase text-center ct-fw-600">'.$name.'</p>
                        <p class="ct-fw-400 text-center">' . $position . '</p>
                    </div>
                    </a>
                ';




        }else{
            $html = '
                    <a href="'.$link.'">
                        <img src="' . esc_url($image) . '" alt="' . esc_attr($name) . '">
                        <div class="ct-teamMember--bg ct-u-paddingBoth20">
                            <p class="text-uppercase text-center ct-fw-600">'.$name.'</p>
                            <p class="ct-fw-400 text-center">' . $position . '</p>
                        </div>
                        <div class="ct-u-motiveDark">
                            <p class="text-center ct-u-paddingTop15 ct-u-paddingBottom60">'.$desc.'</p>
                            <div class="ct-curlPlus-wrapper">
                                <div class="ct-curlPlus ct-curlPlus--topleft"></div>
                                <div class="ct-curlPlus ct-curlPlus--bottomright"></div>
                                <span>+</span>
                            </div>
                        </div>
                    </a>
               ';


        }


        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . do_shortcode($html) . '</div>';

        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(

            'type' => array('label' => __('Type', 'ct_theme'), 'default' => '1', 'type' => 'select',
                'choices' => array('1' => 'large', '2' => 'standard'), 'help' => __("Tyoe of box", 'ct_theme')),

            'name' => array('label' => __('Name', 'ct_theme'), 'default' => '', 'type' => 'input'),

            'position' => array('label' => __('Position', 'ct_theme'), 'default' => '', 'type' => 'input'),

            'desc' => array('label' => __('Small Description', 'ct_theme'), 'default' => '', 'type' => 'input',
            'dependency' => array(
                'element'=> 'type',
                'value' => array('2'))
        ),
            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
            'link'      => array( 'label' => __( 'Link', 'ct_theme' ), 'default' => '', 'type' => 'input' ),



            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-user',
	        'description' => __( "Create single person box", 'ct_theme')
	        ));
    }

}

new ctPersonBoxShortcode();
