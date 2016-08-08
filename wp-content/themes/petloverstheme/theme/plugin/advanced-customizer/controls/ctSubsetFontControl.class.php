<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}


class ctSubsetFontControl extends WP_Customize_Control implements ctControlsFilterableInterface {
	protected $subsets = array();

	protected $chained;

	protected $selectId;

	public function __construct( $manager, $id, $options = array() ) {
		$this->subsets = array(
			'latin' => esc_html__('Latin', 'ct_theme'),
			'latin-ext' => esc_html__('Latin Extended', 'ct_theme'),
			'greek' => esc_html__('Greek', 'ct_theme'),
			'greek-ext' => esc_html__('Greek Extended', 'ct_theme'),
			'cyrillic' => esc_html__('Cyrillic', 'ct_theme'),
			'cyrillic-ext' => esc_html__('Cyrillic Extended', 'ct_theme'),
			'vietnamese' => esc_html__('Vietnamese', 'ct_theme'),
			'khmer' => esc_html__('Khmer', 'ct_theme'),
			'devanagari' => esc_html__('Devanagari', 'ct_theme'),
		);
		$this->selectId = $options['lessname'];

		$this->chained = substr($options['lessname'], 0, -3);

		parent::__construct( $manager, $id, $options );
	}


	public function enqueue() {
		wp_enqueue_script( 'chained',
			CT_THEME_DIR_URI . '/theme/plugin/advanced-customizer/assets/js/jquery.chained.min.js',
			array( 'jquery' ) );
	}


	/**
	 * Render the content of the category dropdown
	 *
	 * @return string
	 */
	public function render_content() {
		if ( ! empty( $this->subsets ) ) {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select id="customizer_font_set_<?php echo esc_attr($this->selectId) ?>" <?php $this->link(); ?>>
					<?php
					foreach ( $this->subsets as $k => $v ) {
						printf( '<option value="%s" %s>%s</option>',
							$k,
							selected( $this->value(), $k, false ),
							$v );
					}
					?>
				</select>
			</label>
			<?php
			echo esc_js('<script>jQuery(function(){jQuery("#customizer_font_' . $this->chained . '").chained("#customizer_font_set_' . $this->selectId . '")})</script>');

		}
	}

	/** Filter value from form, add validation, prefix, suffix ect.
	 *
	 * @param string $val value from form
	 * @param $options
	 *
	 * @return mixed filtred $val
	 */
	public function filter( $val ) {
		return false;
	}
}