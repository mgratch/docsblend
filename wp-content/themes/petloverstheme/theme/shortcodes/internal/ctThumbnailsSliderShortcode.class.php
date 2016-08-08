<?php

/**
 * Flex Slider shortcode
 */
class ctThumbnailsSliderShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Logo Slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'thumbnails_slider';
	}

	public function enqueueScripts() {

		wp_register_script( 'ct-flex-slider', CT_THEME_ASSETS . '/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'ct-flex-slider' );

		wp_register_script( 'ct-flexslider_init', CT_THEME_ASSETS . '/js/flexslider/init.js', array( 'ct-flex-slider' ), false, true );
		wp_enqueue_script( 'ct-flexslider_init' );
	}


	/**
	 * Handles shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */

	public function handle( $atts, $content = null ) {
		$attributes = shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts );
		extract( $attributes );




			$html= '<div class="ct-logoSlider">
    <div class="container">
        <div class="flexslider ct-js-flexslider ct-flexslider--margin25" data-controlnav="false" data-slideshow="true" data-maxitems="5"
             data-move="1" data-itemwidth="202" data-itemmargin="25">
            <ul class="slides">
                '.$content.'
                  </ul>
        </div>
    </div>
</div>';



		return do_shortcode( $html );
	}


	/**
	 * Returns config
	 * @return null
	 *
	 *
	 */
	public function getAttributes() {
		return array(
			'widgetmode' => array('default' => 'true', 'type' => false),
			'class'       => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => __( 'Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme' )
			),

		);
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => 'thumbnails_slider_item', 'min' => 1, 'max' => 20, 'default_qty' => 1 );
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-picture-o' ) );
	}
}

new ctThumbnailsSliderShortcode();