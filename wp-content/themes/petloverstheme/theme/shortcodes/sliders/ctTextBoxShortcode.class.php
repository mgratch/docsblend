<?php

/**
 * Pricelist shortcode
 */
class ctTextBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Text box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'text_box';
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


        if(strpos($title, '*') !== false){
            $title2 = explode('*', $title);

            $print = ''.$title2[0].' <span> '.$title2[1].' </span>';
        }else{
            $print =' '.$title.'';
        }

if($type == '1') {
    $html = '
                    <div class="container ct-u-positionRelative">
    <div class="ct-u-positionRelative">
        <div class="ct-pageSectionHeader ct-offsetTop25 ct-u-borderBottomGrayLighter">
            <h4 class="ct-fw-300 ct-u-size40 ct-u-paddingBottom20">' . $print . '</h4>
            <div class="ct-u-paddingBottom40">
                <p class="text-justify">' . $content . '</p>
            </div>
        </div>
    </div>
</div>
            ';
}else{
    $html='
<div class="container ct-u-positionRelative">
    <div class="ct-u-positionRelative">
        <div class="ct-pageSectionHeader ct-u-paddingTop30 ct-u-borderBottomGrayLighter">
            <h4 class="ct-fw-300 ct-u-size40 ct-u-paddingBottom20">' . $print . '</h4>
            <div class="ct-u-paddingBottom40">
                <p class="text-justify">' . $content . '</p>
            </div>
        </div>
    </div>
</div>
    '
    ;
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
            'label' => __('position', 'ct_theme'),
            'default' => '1',
            'type' => 'select',
            'choices' =>
                array(
                    "1" => __("Up", "ct_theme"),
                    "2" => __("Down", "ct_theme"),
                 ),
        );

        $items['title'] = array(
            'label' => __('Title (add * if you want black and motive font color)', 'ct_theme'),
            'type' => 'input',
    );

        $items['content'] = array(
            'label' => __('Content', 'ct_theme'),
            'type' => 'content',
        );


      return $items;

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

new ctTextBoxShortcode();



