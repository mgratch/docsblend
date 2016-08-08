<?php

/**
 * BlockQuote shortcode
 */
class ctBlockQuoteShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Block quote';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'blockquote';
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

        /*
        $format1Html = $this->buildRelatedShortcodeIf('format', $atts, 'content', 'format1');
        $format2Html = $this->buildRelatedShortcodeIf('format', $atts, 'content', 'format2');
        $format3Html = $this->buildRelatedShortcodeIf('format', $atts, 'content', 'format3');
        $format4Html = $this->buildRelatedShortcodeIf('format', $atts, 'content', 'format4');
        */




        switch ($type) {
            case 1:

                $html = '
        <div class="col-sm-2 hidden-xs">
            <div class="ct-quoteIcons"><i class="fa fa-user"></i></div>
        </div>
        <div class="col-sm-10 ct-u-paddingBoth10 animated fadeIn activate">
            <p class="ct-fw-400 ct-u-marginBottom0">'.$content.'</p>
            <span class="ct-u-size18 ct-fw-600"> - '.$name .' </span>
        </div>
    ';
                break;

            case 2:


                $html = '

            <p class="ct-fw-400 ct-u-marginBottom0">'.$content.'</p>
            <span class="ct-u-size18 ct-fw-600"> - '.$name .' </span>

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

            'type' => array('label' => __('Blockquote type', 'ct_theme'), 'default' => '4', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',

            )),

            'name' => array('label' => __('Author Name', 'ct_theme'), 'default' => '', 'type' => 'input'),

            'content' => array('label' => __('Quote', 'ct_theme'), 'default' => '', 'type' => "textarea"),

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
	        'icon' => 'fa-quote-left',
	        'description' => __( "Add text in custom block quote", 'ct_theme')
	        ));
    }
}

new ctBlockQuoteShortcode();