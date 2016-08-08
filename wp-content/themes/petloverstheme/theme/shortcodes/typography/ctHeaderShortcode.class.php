<?php

/**
 * Header shortcode
 */
class ctHeaderShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Header';
    }


    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'header';
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

        $mainContainerAtts = array(
            'class' => array(
                'ct-sectionHeader',
                'ct-u-borderTopGrayLighter',
                $class
            ),
        );


        $margintop='';
        $marginbottom='';
        $marginboth='';
        $paddingtop='';
        $paddingbottom='';
        $paddingboth='';


        if($margin_top!= '0'){
            $margintop = 'ct-u-marginTop'.$margin_top;
        }

        if($margin_bottom!= '0'){
            $marginbottom = 'ct-u-marginBottom'.$margin_bottom;
        }

       /* if($margin_both!= ''){
            $marginboth = 'ct-u-marginBoth'.$margin_both;
        }*/



        if($padding_top!= '0'){
            $paddingtop = 'ct-u-paddingTop'.$padding_top;
        }

        if($padding_bottom!= '0'){
            $paddingbottom = 'ct-u-paddingBottom'.$padding_bottom;
        }

      /*  if($padding_both!= ''){
            $paddingboth = 'ct-u-paddingBoth'.$padding_both;

        }*/


        if(strpos($title, '*') !== false){
            $title2 = explode('*', $title);

            $print = ''.$title2[0].' <span> '.$title2[1].' </span>';
        }else{
            $print =' '.$title.'';
        }




switch ($type){

    default:
    case 'default':
    $mainContainerAtts = array(
        'class' => array(
            'ct-sectionHeader',
            $border,
            $placement,
            $class
        ),
    );

            $html=
        ' <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '  >
            <h'. $level .' class=" '.$placement.'  '.$uppercase.'  '.$font_weight_title.' '.$font_size_title.'  '.$title_color.'">'.$print.'</h'.$level.'>
            <h'.$sub_level.' class="  '.$uppercase.'  '.$font_weight_sub.' '.$font_size_sub.' '.$subtitle_color.'">'.$subtitle.'</h'.$sub_level.'>
            </div>

            ';

        break;



    case'slider':
        $html = '

        <div class="ct-slideInSection ct-slideInSection--'.$side.' ct-slideInSection--'.$slider_color.' ct-u-paddingBoth20 animated" data-fx="bounceIn'.$side.'">
    <div class="ct-pageSectionHeader">
    <h'. $level .' class=" '.$placement.' '.$uppercase.' '.$margintop.' '.$marginbottom.' '.$paddingtop.' '. $paddingbottom.'">'.$print.'</h'. $level .'>
         <h'.$sub_level.' class=" '.$placement.' '.$uppercase.'  '.$font_weight_sub.' '.$font_size_sub.' '.$subtitle_color.'">'.$subtitle.'</h'.$sub_level.'>
    </div>
</div>
        ';


break;



    case 'simple':
        $html = '
            <h'. $level .' class="'.$title_color.'  '.$uppercase.' '.$margintop.' '.$marginbottom.' '.$paddingtop.' '. $paddingbottom.' '.$font_weight.' '.$font_size.' '.$italic.' '.$border.'">'.$print.'</h'. $level .'>
            ';

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

        $items = array(

            'type' => array(
                'label' => __('type', 'ct_theme'),
                'default' => '',
                'type' => 'select',
                'options' => array(
                    'default' => __('Default', 'ct_theme'),
                    'slider' => __('Slider', 'ct_theme'),
                    'simple' => __('Simple', 'ct_theme')
                )
            ),

            'side' => array(
                'label' => __('Side', 'ct_theme'),
                'default' => 'left',
                'type' => 'select',
                'options' => array(
                    'Left' => 'Left',
                    'Right' => 'Right',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'slider')
                )),
            'slider_color' => array(
                'label' => __('Slider Color', 'ct_theme'),
                'default' => 'motive',
                'type' => 'select',
                'options' => array(
                    'motive' => 'motive',
                    'motiveLight' => 'motiveLight',
                    'motiveDark' => 'motiveDark',
                    'success' => 'success',
                    'danger' => 'danger',
                    'warning' => 'warning',
                    'info' => 'info',
                    'primary' => 'primary',
                    'default' => 'default',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'slider')
                )),




            'title' => array('label' => __("Title (add * if you want black and motive font color)", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __("SubTitle", 'ct_theme'), 'default' => '', 'type' => 'input',

                'dependency' => array(
                'element' => 'type',
                'value'   => array( 'default', 'slider')
            )),



            'placement' => array(
                'label' => __('Placement Title', 'ct_theme'),
                'default' => 'text-center',
                'type' => 'select',
                'options' => array(
                    'text-left' => __('Left', 'ct_theme'),
                    'text-center' => __('Center', 'ct_theme'),
                    'text-right' => __('Right', 'ct_theme'),
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default', 'slider')
                )),





            'class' => array(
                'label' => __("Custom class", 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Adding custom class allows you to set diverse styles in css to the element. type in name of class, which you defined in css. you can add as much classes as you like.", 'ct_theme')),




            'level' => array(
                'label' => __('Title level (1-6)', 'ct_theme'),
                'default' => '2',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '2' => '2',
                    '1' => '1',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
    ),


            'sub_level' => array(
                'label' => __('SubTitle level (1-6)', 'ct_theme'),
                'default' => '3',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '3' => '3',
                    '1' => '1',
                    '2' => '2',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default', 'slider')
                )),



           'title_color'      => array(
                'label'   => __( 'Title Color', 'ct_theme' ),
                'default' => '',
                'group' => 'Advanced',
                'type'    => "select",
                'options' => array(
                    '' => 'no',
                    'ct-u-motiveLight' => 'motive',
                    'ct-u-motiveBody' => 'white',

                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default', 'simple')
                )
            ),

            'subtitle_color'      => array(
                'label'   => __( 'SubTitle Color', 'ct_theme' ),
                'default' => '',
                'group' => 'Advanced',
                'type'    => "select",
                'options' => array(
                    '' => 'no',
                    'ct-u-motiveLight' => 'motive',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default')
                )
            ),




            'uppercase' => array(
                'label' => __('Uppercase', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'text-uppercase' => 'yes',
                )
            ),

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
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'simple')
                )
            ),


            'font_size' => array(
                'label' => __('Font size', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-u-size12' => 'size12',
                    'ct-u-size14' => 'size14',
                    'ct-u-size16' => 'size16',
                    'ct-u-size17' => 'size17',
                    'ct-u-size18' => 'size18',
                    'ct-u-size20' => 'size20',
                    'ct-u-size22' => 'size22',
                    'ct-u-size24' => 'size24',
                    'ct-u-size26' => 'size26',
                    'ct-u-size28' => 'size28',
                    'ct-u-size30' => 'size30',
                    'ct-u-size34' => 'size34',
                    'ct-u-size40' => 'size40',
                    'ct-u-size50' => 'size50',
                    'ct-u-size56' => 'size56',
                    'ct-u-size60' => 'size60',
                    'ct-u-size70' => 'size70',
                    'ct-u-size80' => 'size80',
                    'ct-u-size90' => 'size90',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'simple')
                )
            ),













            'font_weight_title' => array(
                'label' => __('Font weight Tittle', 'ct_theme'),
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
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default')
                )
            ),


            'font_size_title' => array(
                'label' => __('Font size Tittle', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-u-size12' => 'size12',
                    'ct-u-size14' => 'size14',
                    'ct-u-size16' => 'size16',
                    'ct-u-size17' => 'size17',
                    'ct-u-size18' => 'size18',
                    'ct-u-size20' => 'size20',
                    'ct-u-size22' => 'size22',
                    'ct-u-size24' => 'size24',
                    'ct-u-size26' => 'size26',
                    'ct-u-size28' => 'size28',
                    'ct-u-size30' => 'size30',
                    'ct-u-size34' => 'size34',
                    'ct-u-size40' => 'size40',
                    'ct-u-size50' => 'size50',
                    'ct-u-size56' => 'size56',
                    'ct-u-size60' => 'size60',
                    'ct-u-size70' => 'size70',
                    'ct-u-size80' => 'size80',
                    'ct-u-size90' => 'size90',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default')
                )
            ),
            'font_weight_sub' => array(
                'label' => __('Font weight subTittle', 'ct_theme'),
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
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default')
                )
            ),


            'font_size_sub' => array(
                'label' => __('Font size subTittle', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-u-size12' => 'size12',
                    'ct-u-size14' => 'size14',
                    'ct-u-size16' => 'size16',
                    'ct-u-size17' => 'size17',
                    'ct-u-size18' => 'size18',
                    'ct-u-size20' => 'size20',
                    'ct-u-size22' => 'size22',
                    'ct-u-size24' => 'size24',
                    'ct-u-size26' => 'size26',
                    'ct-u-size28' => 'size28',
                    'ct-u-size30' => 'size30',
                    'ct-u-size34' => 'size34',
                    'ct-u-size40' => 'size40',
                    'ct-u-size50' => 'size50',
                    'ct-u-size56' => 'size56',
                    'ct-u-size60' => 'size60',
                    'ct-u-size70' => 'size70',
                    'ct-u-size80' => 'size80',
                    'ct-u-size90' => 'size90',
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default')
                )
            ),



















            'italic' => array(
                'label' => __('italic', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-fs-i' => 'yes',

                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'simple')
                )
            ),

            'border' => array(
                'label' => __('border', 'ct_theme'),
                'default' => '',
                'group' => 'Advanced',
                'type' => 'select',
                'options' => array(
                    '' => 'no',
                    'ct-u-doubleBorderBottom' => 'Double border bottom',
                    'ct-u-doubleBorderTop' => 'Double border top',
                    'ct-u-borderTopGrayLighter' =>'Border Top gray',

                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => array( 'default', 'simple')
                )
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

        );




        return $items;

    }

    /**
     * Add any pre custom shortcode attributes
     *
     * @param $items
     *
     * @return mixed
     */

    protected function preMergeAdditionalShortcodeAttributes($items)
    {
        return $items;
    }

    /**
     * Allows to add additional extensions
     * @see ctSectionHeader
     *
     * @param $items
     * @param $group
     *
     * @return mixed
     */

    protected function mergeAdditionalShortcodeAttributes($items)
    {
        return $items;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-header',
            'description' => __("Create a custom header", 'ct_theme')
        ));
    }
}

new ctHeaderShortcode();