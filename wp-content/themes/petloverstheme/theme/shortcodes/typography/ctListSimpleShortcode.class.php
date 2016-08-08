<?php

/**
 * List shortcode
 */
class ctListSimpleShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Simple';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_simple';
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
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */

	public static $type;


	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );

		$mainContainerAtts = array(
			'class' => array(
				'',
				$class
			),
		);




		switch ($type) {
			default:
			case 'ordered':
				self::$type = 'ordered';
				$html = '<ol>' . do_shortcode($content) . '</ol>';
				break;

			case 'ordered_bold':
				self::$type = 'ordered_bold';
				$html = '<ol class="ct-fw-600">' . do_shortcode($content) . '</ol>';
				break;

			case 'unordered':
				self::$type = 'unordered';
				$html = '<ul>' . do_shortcode($content) . '</ul>';
				break;

			case 'unordered_bold':
				self::$type = 'unordered_bold';
				$html = '<ul class="ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;


			case 'no_bullets':
				self::$type = 'no_bullets';
				$html = '<ul class="list-unstyled">' . do_shortcode($content) . '</ul>';
				break;

			case 'no_bullets_bold':
				self::$type = 'no_bullets_bold';
				$html = '<ul class="list-unstyled ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;


			case 'inline':
				self::$type = 'inline';
				$html = '<ul class="list-inline">' . do_shortcode($content) . '</ul>';
				break;
			case 'inline_bold':
				self::$type = 'inline_bold';
				$html = '<ul class="list-inline ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;




			case 'list_group':
				self::$type = 'list_group';
				$html = '<ul class="list-group">' . do_shortcode($content) . '</ul>';
				break;

			case 'list_group_bold':
				self::$type = 'list_group_bold';
				$html = '<ul class="list-group ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;




			case 'list_group_with_badges':
				self::$type = 'list_group_with_badges';
				$html = '<ul class="list-group">' . do_shortcode($content) . '</ul>';
				break;

			case 'list_group_with_badges_bold':
				self::$type = 'list_group_with_badges_bold';
				$html = '<ul class="list-group ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;







			case 'list_group_headings':
				self::$type = 'list_group_headings';
				$html = '<div class="list-group">' . do_shortcode($content) . '</div>';
				break;





		}



		return do_shortcode( $html );
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'list_simple_item', 'min' => 1, 'max' => 20, 'default_qty' => 2 );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(


				'type' => array('label' => __('type', 'ct_theme'),
					'default' => 'ordered',
					'type' => 'select',
					'options' => array(
						'ordered' => __('ordered','ct_theme'),
						'ordered_bold' => __('ordered bold','ct_theme'),
						'unordered' => __('unordered','ct_theme'),
						'unordered_bold' => __('unordered bold','ct_theme'),
						'no_bullets' => __('no bullets','ct_theme'),
						'no_bullets_bold' => __('no bullets bold','ct_theme'),
						'inline' => __('inline','ct_theme'),
						'inline_bold' => __('inline bold','ct_theme'),
						'list_group' => __('list group','ct_theme'),
						'list_group_bold' => __('list group bold','ct_theme'),
						'list_group_with_badges' => __('list group with badges','ct_theme'),
						'list_group_with_badges_bold' => __('list group with badges bold','ct_theme'),
						'list_group_headings' => __('list group headings','ct_theme'),
					)),


				'class'   => array(
					'label'   => __( 'Custom class', 'ct_theme' ),
					'type'    => 'input',
					'default' => '',
					'help'    => __('Set custom class to element', 'ct_theme')
				),

			);

	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon'        => 'fa-list',
			'description' => __( "Add list group", 'ct_theme' )
		) );
	}
}

new ctListSimpleShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortcode_list_simple extends WPBakeryShortCodesContainer{}
}