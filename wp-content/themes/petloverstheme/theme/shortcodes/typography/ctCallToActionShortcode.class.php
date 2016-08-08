<?php

/**
 * Paragraph shortcode
 */
class ctCallToActionShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Call to Action';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'call_to_action';
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
        $buttonHtml = $this->buildRelatedShortcodeIf('button', $atts, 'content','button_rel');



        $html = '




        <div class="col-md-12 ct-slideInRightSection pull-right ct-u-motiveLight2--bg ct-u-marginBoth50 animated" data-fx="bounceInRight ct-show">
                <div class="row ct-u-borderMotiveBottom">
                    <div class="col-sm-3 ct-u-clearPadding"><img class="ct-img100" src="'.$image.'" alt="' . $title . '"></div>
                    <div class="col-sm-9 ct-u-motiveLight2--bg ct-u-paddingTop20 ct-u-paddingBottom10">
                        <h4 class="ct-u-motiveDark ct-u-marginBottom10">' . $title . '</h4>
                        <span class="motive text-uppercase ct-fw-600 ct-u-size18">' . $subtitle . '</span>
                        <p class="ct-u-marginBottom10">'.$content.'</p>
                        ' . $buttonHtml . '
                    </div>
                </div>
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
        $items = array(

            'title' => array('label' => __('Title', 'Title'), 'default' => '', 'type' => 'input',),
            'subtitle' => array('label' => __('SubTitle', 'Title'), 'default' => '', 'type' => 'input',),
            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),

            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),


            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input'),


        );

        $items = $this->mergeShortcodeAttributes($items, 'button', 'button_rel', __('Button', 'ct_theme'));
        return $items;
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-bell' ) );
    }
}

new ctCallToActionShortcode();