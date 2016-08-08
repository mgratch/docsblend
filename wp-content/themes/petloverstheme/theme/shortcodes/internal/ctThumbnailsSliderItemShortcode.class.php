<?php

/**
 * Flex Slider Item shortcode
 */
class ctThumbnailsSliderItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Logo Slider Item';
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */
	public function getParentShortcodeName() {
		return 'thumbnails_slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'thumbnails_slider_item';
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

		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );


		$mainContainerAtts = array();






		$item = '<li class="ct-u-marginBoth40"' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '>'

		;
		if($image!=''){
			$item .= '<img src="' . $image . '" alt="logo">';
		}

		$item .= '</li>';

		return do_shortcode( $item );
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$items = array();


			$items['image'] = array(
				'label'   => __( "Image", 'ct_theme' ),
				'default' => '',
				'type'    => 'image',
				'help'    => __( "Image source", 'ct_theme' )
			);

		return $items;

	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-picture-o' ) );
	}

}

new ctThumbnailsSliderItemShortcode();