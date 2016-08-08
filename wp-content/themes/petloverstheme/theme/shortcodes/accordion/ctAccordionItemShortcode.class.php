<?php

/**
 * Accordion item shortcode
 */
class ctAccordionItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Accordion item';
    }


    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'accordion_item';
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
        $isActive = $active == 'yes';
        $parent_id = call_user_func('ctAccordionShortcode::getParentId');
        $id = rand(100, 1000);


        $mainContainerAtts = array(
            'class' => array(
                'panel',
                'panel-' . $style . '',
                ($isActive ? 'accordion' : '')
            ),

        );

        $btn = '';
        switch ($style) {
            case 'default':
                $btn = 'motive';
                break;
            case 'success':
                $btn = 'success';
                break;
            case 'danger':
                $btn = 'danger';
                break;
            case 'warning':
                $btn = 'warning';
                break;
            case 'info':
                $btn = 'info';
                break;
            case 'motive':
                $btn = 'motive-inverse';
                break;
        }


        return '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                <div class="panel-heading">
                    <div class="panel-title">

                        <a data-toggle="collapse" data-parent="#' . $parent_id . '" href="#collapse' . $id . '" ' . ($isActive ? '' : 'class="collapsed" ') . '>
                            <div class="ct-Diamond ct-Diamond--' . $btn . '"></div> ' . $title . '
        </a>
                    </div>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse ' . ($isActive ? 'in ' : '') . '">
                    <div class="panel-body">
        ' . do_shortcode($content) . '
                    </div>
                </div>
            </div>


            ';

    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }

    /**
     * Parent shortcode name
     * @return null
     */

    public function getParentShortcodeName()
    {
        return 'accordion';
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Every accordion item should be wrapped in accordion element.', 'ct_theme')),
            'style' => array('label' => __('Style', 'ct_theme'), 'default' => 'default', 'type' => 'select', 'choices' => array(
                'default' => __('default', 'ct_theme'),
                'success' => __('success', 'ct_theme'),
                'danger' => __('danger', 'ct_theme'),
                'warning' => __('warning', 'ct_theme'),
                'info' => __('info', 'ct_theme'),
                'motive' => __('motive', 'ct_theme'),
            )),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'active' => array('label' => __('is active', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')),),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-bars',
            'container'=>true,
            'description' => __("Add a child element of the accordion", 'ct_theme')
        ));
    }
}


new ctAccordionItemShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortcode_accordion_item extends WPBakeryShortCodesContainer{}
}