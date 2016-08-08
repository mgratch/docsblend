<?php

/**
 * Font awesome parser
 * @author alex
 */
class ctFontAwesomeHelper {

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
		if ( ! $path ) {
			foreach (
				array(
					CT_THEME_DIR . '/assets/fonts/fontawesome/less/icons.less',
					CT_THEME_DIR . '/assets/less/font-awesome.less',
					CT_THEME_DIR . '/assets/less/awesome.less'
				) as $path
			) {
				if ( file_exists( $path ) ) {
					break;
				}
			}
		}
		$this->path = $path;

		if ( ! self::$fonts ) {
			$this->parseFontAwesome();
		}
	}

	/**
	 * Font
	 *
	 * @param $css
	 */

	public static function prefixFont( $css ) {
		if ( strpos( $css, 'fa-' ) !== false ) {
			$css = 'fa ' . $css;
		}

		return $css;
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

	protected function parseFontAwesome() {
		if ( strpos( $this->path, 'icons.less' ) === false ) {
			$css           = file_get_contents( $this->path );
			$fa_css_prefix = 'fa';
			$pattern       = '/\.(' . $fa_css_prefix . '-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';

			preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );

			$data[] = array( 'class' => '', 'content' => '' );
			foreach ( $matches as $match ) {
				$data[ $match[1] ] = array( 'class' => $match[1], 'content' => $match[2] );
			}
		} else {
			$data = $this->parseNewFontAwesome();
		}

		self::$fonts[ md5( $this->path ) ] = $data;
	}

	/**
	 * New font awesome standard
	 * @return array
	 */

	protected function parseNewFontAwesome() {
		//get variables

		$css = file_get_contents( CT_THEME_DIR . '/assets/fonts/fontawesome/less/variables.less' );

		$fa_css_prefix = '\@fa\-var';
		$pattern       = '/(' . $fa_css_prefix . '-(?:\w+(?:-)?)+):\s*"(.+)";/';

		preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );
		$vars = array();
		foreach ( $matches as $match ) {
			$vars[ str_replace( '@fa-var', 'fa', $match[1] ) ] = $match[2];
		}
		$css = file_get_contents( $this->path );

		$fa_css_prefix = '\@\{fa\-css\-prefix\}';
		$pattern       = '/\.(' . $fa_css_prefix . '-(?:\w+(?:-)?)+):before\s+{\s*content:\s*@(.+);\s+}/';

		preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );

		$data[] = array( 'class' => '', 'content' => '' );
		foreach ( $matches as $match ) {
			$c          = str_replace( '@{fa-css-prefix}', 'fa', $match[1] );
			$content    = isset( $vars[ $c ] ) ? $vars[ $c ] : '';
			$data[ $c ] = array(
				'class'   => $c,
				'content' => $content
			);
		}

		return $data;
	}

}

//register helper
add_filter( 'ct_font_helper.prefix_font', array( 'ctFontAwesomeHelper', 'prefixFont' ) );