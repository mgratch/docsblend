<?php

/**
 * EtLine parser
 * @author alex
 */
class ctFontEtLineHelper {

	/**
	 * @var array
	 */
	protected static $fonts;


	/**
	 * Font path
	 * @var string
	 */
	protected $path;

	/**
	 * Create fonts
	 *
	 * @param string $path
	 */

	public function __construct( $path = '' ) {
		add_filter( 'ct_visual_composer_integrator.icon.pre_parsed', array( $this, 'attachStyles' ) );

		if ( ! $path ) {
			foreach (
				array(
					CT_THEME_DIR . '/assets/fonts/et-line-font/style.less',
				) as $path
			) {
				if ( file_exists( $path ) ) {
					break;
				}
			}
		}
		$this->path = $path;

		if ( ! self::$fonts ) {
			$this->parseFont();
		}
	}

	/**
	 * Attach inline style
	 */

	public function attachStyles( $value ) {
		if ( file_exists( $this->path ) ) {
			$value.= '<link rel="stylesheet" href="' . esc_url( CT_THEME_ASSETS.'/fonts/et-line-font/style.css' ) . '" type="text/css" media="all">';
		}


		return $value;
	}

	/**
	 * Return font awesome fonts
	 * @return mixed
	 */

	public function getFonts() {
		return self::$fonts[ md5( $this->path ) ];
	}


	/**
	 * Font awesome parsing
	 */

	protected function parseFont() {
		$css           = file_get_contents( $this->path );
		$fa_css_prefix = 'icon';
		$pattern       = '/\.(' . $fa_css_prefix . '-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';

		preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );

		$data[] = array( 'class' => '', 'content' => '' );
		foreach ( $matches as $match ) {
			$data[ $match[1] ] = array( 'class' => $match[1], 'content' => $match[2] );
		}
		self::$fonts[ md5( $this->path ) ] = $data;
	}

}