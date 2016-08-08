<?php
/**
 * Dropcap shortcode
 */
class ctDropcapShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Dropcap';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'dropcap';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		return do_shortcode('<p class="dropcap">' . $content . '</p>');
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'content' => array(
				'label' => __('content', 'ct_theme'),
				'default' => '',
				'type' => "textarea",
				'help' => __("Add all text in textarea - first letter will be adjusted automatically", 'ct_theme')
				)
		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon' => 'fa-list',
			'description' => __( "Drop cap styled text", 'ct_theme')
			) );
	}
}

new ctDropcapShortcode();