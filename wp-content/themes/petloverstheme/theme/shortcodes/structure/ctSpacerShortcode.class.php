<?php

/**
 *
 * @author alex
 */
class ctSpacerShortcode extends ctShortcode
{

    /**
     * Returns shortcode label
     * @return mixed
     */
    public function getName()
    {
        return "Spacer";
    }

    /**
     * Returns shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'spacer';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return mixed
     */
    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $dataHeight = '';

        /*
		if (strpos($height, '%' ) === false && $height) {
            $dataHeight= 'data-height="'.$height.'"';
			$height .= 'px';
		}

        if ($device == 'large'){
            $deviceClass = 'visible-lg';
        } else if ($device == 'medium'){
            $deviceClass = 'visible-md';
        }else{
            $deviceClass = '';
        }

        $html = $height ? '<div '.$dataHeight.'  class="spacer '.$deviceClass.'" style="height:' .$height. '"></div>'
            : '<div data-height="20" class="spacer '.$deviceClass.'" style="height:20px"></div>';
*/

        return '<br>';
    }

    /**
     * Returns config
     * @return array
     */
    public function getAttributes()
    {
        return array();
    }
}

new ctSpacerShortcode();