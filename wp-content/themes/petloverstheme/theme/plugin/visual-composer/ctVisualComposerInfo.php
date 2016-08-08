<?php

/**
 * Additional info for VC for custom rendering
 * @author alex
 */
class ctVisualComposerInfo {
	/**
	 * @var bool
	 */

	protected $isContainer = false;

	/**
	 * @var array
	 */

	protected $adminLabels = array();

	/**
	 * @var string
	 */

	protected $icon;

	/**
	 * @var string
	 */

	protected $description = '';

	/**
	 * @var ctShortcode
	 */

	protected $shortcode;

	/**
	 * @param ctShortcode $shortcode
	 * @param array $options
	 */

	public function __construct( ctShortcode $shortcode, $options = array() ) {
		$this->shortcode = $shortcode;
		$this->setupOptions( $options );
	}

	/**
	 * Sets required options
	 *
	 * @param $options
	 *
	 * @throws Exception
	 */

	protected function setupOptions( $options ) {
		$options = apply_filters( 'ct_visual_composer_integrator.info.options', $options );

		foreach ( $options as $o => $val ) {
			$m = 'set' . strtoupper( $o );
			if ( ! method_exists( $this, $m ) ) {
				throw new Exception( "Option " . $o . '(' . $m . ') does not exists!' );
			}
			$this->$m( $val );
		}
	}

	/**
	 * @return string
	 * @author alex
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 *
	 * @author alex
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}


	/**
	 * @return string
	 * @author alex
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param string $icon
	 *
	 * @author alex
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;
	}


	/**
	 * Should we show this as admin label in VS edit?
	 *
	 * @param $val
	 */

	public function setAdminLabels( $val ) {
		$this->adminLabels = $val;
	}

	/**
	 * Show admin label?
	 *
	 * @return array
	 */

	public function getAdminLabels() {
		return $this->adminLabels;
	}

	/**
	 * Supports elements inside?
	 * @return bool
	 */

	public function isContainer() {
		return $this->isContainer;
	}

	/**
	 * Elements supports nested elements
	 *
	 * @param $val
	 */

	public function setContainer( $val ) {
		$this->isContainer = $val;
	}
}