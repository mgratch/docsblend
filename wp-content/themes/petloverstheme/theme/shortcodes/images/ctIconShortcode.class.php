<?php

/**
 * Pricelist shortcode
 */
class ctIconShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Icon';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'icon';
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

	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );
		if ( ! $name ) {
			return '';
		}

		$mainContainerAtts = array(
			'class' => array(
				apply_filters('ct_font_helper.prefix_font',$name), //adjust for custom prefix
				$name,
				$class,
				$rotate != '' ? 'fa-' . $rotate : '',
				$flip_vertical,
				$flip_horizontal,
				$spin,
				$border,
				$fixed_width,
			//	$pull,
				$size,
			),

		);

		if ( $size_px != '' ) {
			$mainContainerAtts['style'] = 'color:' .$icon_color. '; font-size:' . $size_px . 'px';
		} else {
			$mainContainerAtts['class'][] = $size;
			$mainContainerAtts['style']   = 'color:'. $icon_color;
		}

		$html = '<i ' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '></i>';

		return $html;
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'name'            => array(
				'label'   => __( 'Icon', 'ct_theme' ),
				'type'    => "icon",
				'font_types'=>array('awesome','etline'),
				'default' => '',
				'link'    => CT_THEME_ASSETS . '/shortcode/awesome/index.html'
			),
			'icon_color'      => array(
				'label'   => __( 'Color', 'ct_theme' ),
				'type'    => "colorpicker",
				'default' => '#d30000'
			),
			'size'            => array(
				'label'   => __( 'Size', 'ct_theme' ),
				'default' => '',
				'type'    => 'select',
				'choices' => array(
					''      => __( 'normal', 'ct_theme' ),
					'fa-lg' => __( '33%', 'ct_theme' ),
					'fa-2x' => __( '2x', 'ct_theme' ),
					'fa-3x' => __( '3x', 'ct_theme' ),
					'fa-4x' => __( '4x', 'ct_theme' ),
					'fa-5x' => __( '5x', 'ct_theme' )
				),
			),
			'size_px'         => array( 'label' => __( 'Size in px', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
			/*'pull'            => array(
				'label'   => __( 'Pull', 'ct_theme' ),
				'default' => '',
				'type'    => 'select',
				'choices' => array(
					''           => __( 'none', 'ct_theme' ),
					'pull-left'  => __( 'left', 'ct_theme' ),
					'pull-right' => __( 'right', 'ct_theme' ),
				)
			),*/
			'fixed_width'     => array(
				'label'   => __( "Fixed Width", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-fw',
			),
			'border'          => array(
				'label'   => __( "Border", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-border',
			),

			'list_icon_li'          => array(
				'label'   => __( "Icon list item", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-li',
			),


			'spin'            => array(
				'label'   => __( "Spinning Icon", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-spin',
			),
			'flip_horizontal' => array(
				'label'   => __( "Flip horizontal", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-flip-horizontal',
			),
			'flip_vertical'   => array(
				'label'   => __( "Flip vertical", 'ct_theme' ),
				'type'    => 'checkbox',
				'default' => '',
				'value'   => 'fa-flip-vertical',
			),
			'rotate'          => array(
				'label'   => __( 'Rotate', 'ct_theme' ),
				'default' => '',
				'type'    => 'select',
				'choices' => array(
					''           => __( 'none', 'ct_theme' ),
					'rotate-90'  => __( '90 degrees', 'ct_theme' ),
					'rotate-180' => __( '180 degrees', 'ct_theme' ),
					'rotate-270' => __( '270 degrees', 'ct_theme' ),
				)
			),
			'class'           => array( 'label'   => __( "Custom class", 'ct_theme' ),
			                            'default' => '',
			                            'type'    => 'input',
			                            'help'    => __( 'Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme' )
			),
		);

	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon' => 'fa-picture-o',
			'description' => __( "Add an icon", 'ct_theme')
			) );
	}
}

new ctIconShortcode();
