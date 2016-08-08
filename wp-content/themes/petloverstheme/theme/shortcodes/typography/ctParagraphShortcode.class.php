<?php

/**
 * Paragraph shortcode
 */
class ctParagraphShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Paragraph';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'paragraph';
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

        $mainContainerAtts = array(
            'class' => array(

                $class
            ),
        );


        $margintop='';
        $marginbottom='';
        $marginboth='';
        $paddingtop='';
        $paddingbottom='';
        $paddingboth='';
        $a='';

        if($margin_top!= '0'){
            $margintop = 'ct-u-marginTop'.$margin_top;
        }

        if($margin_bottom!= '0'){
            $marginbottom = 'ct-u-marginBottom'.$margin_bottom;
        }

        if($margin_top=='0' && $margin_bottom =='0'){
            $a ='ct-u-marginBoth0';
        }else{
            $a='';
        }



        if($padding_top!= '0'){
            $paddingtop = 'ct-u-paddingTop'.$padding_top;
        }

        if($padding_bottom!= '0'){
            $paddingbottom = 'ct-u-paddingBottom'.$padding_bottom;
        }




if($span=='no') {
    return do_shortcode('<p class="'.$a.' ' . $justify . ' ' . $font_weight . ' ' . $margintop . ' ' . $marginbottom . ' ' . $paddingtop . ' ' . $paddingbottom . ' " ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $content . '</p>');
}
        else{
            return do_shortcode('<p class="' . $justify . ' ' . $font_weight . ' ' . $margintop . ' ' . $marginbottom . ' ' . $paddingtop . ' ' . $paddingbottom . ' " ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '><span>' . $content . '</span></p>');

        }

    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),

            'justify' => array('label' => __('Justify', 'ct_theme'),
                'default' => 'no', 'type' => 'select',
                'options' => array(
                '' => 'no',
                    'text-justify' => 'yes')),

            'span' => array('label' => __('span', 'ct_theme'),
                'default' => 'no', 'type' => 'select',
                'options' => array(
                    'no' => 'no',
                    'yes' => 'yes')),

            'font_weight' => array(
                'label' => __('Font weight', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-fw-300' => 'fw-300',
                    'ct-fw-400' => 'fw-400',
                    'ct-fw-500' => 'fw-500',
                    'ct-fw-600' => 'fw-600',
                    'ct-fw-700' => 'fw-700',
                    'ct-fw-800' => 'fw-800',
                    'ct-fw-900' => 'fw-900',
                ),

            ),


            'margin_top' => array(
                'label' => __('Margin Top', 'ct_theme'),
                'default' => '0',
                'group' => 'Margin',
                'type' => 'select',
                'options' => array(
                    '0' => '0',
                    '10' => '10',
                    '20' => '20',
                    '30' => '30',
                    '40' => '40',
                    '50' => '50',
                    '60' => '60',
                    '70' => '70',
                    '80' => '80',
                    '90' => '90',
                    '100' => '100',
                )
            ),

            'margin_bottom' => array(
                'label' => __('Margin Bottom', 'ct_theme'),
                'default' => '0',
                'group' => 'Margin',
                'type' => 'select',
                'options' => array(
                    '0' => '0',
                    '10' => '10',
                    '20' => '20',
                    '30' => '30',
                    '40' => '40',
                    '50' => '50',
                    '60' => '60',
                    '70' => '70',
                    '80' => '80',
                    '90' => '90',
                    '100' => '100',
                )
            ),

            'padding_top' => array(
                'label' => __('Padding Top', 'ct_theme'),
                'default' => '0',
                'group' => 'Padding',
                'type' => 'select',
                'options' => array(
                    '0' => '0',
                    '10' => '10',
                    '20' => '20',
                    '30' => '30',
                    '40' => '40',
                    '50' => '50',
                    '60' => '60',
                    '70' => '70',
                    '80' => '80',
                    '90' => '90',
                    '100' => '100',
                )
            ),

            'padding_bottom' => array(
                'label' => __('Padding Bottom', 'ct_theme'),
                'default' => '0',
                'group' => 'Padding',
                'type' => 'select',
                'options' => array(
                    '0' => '0',
                    '10' => '10',
                    '20' => '20',
                    '30' => '30',
                    '40' => '40',
                    '50' => '50',
                    '60' => '60',
                    '70' => '70',
                    '80' => '80',
                    '90' => '90',
                    '100' => '100',
                )
            ),



            'class' => array('label' => __('CSS class', 'ct_theme'), 'default' => '', 'type' => 'input'),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array(
	        'icon' => 'fa-paragraph',
	        'description' => __( "Add text paragraph", 'ct_theme')
	        ) );
    }
}

new ctParagraphShortcode();