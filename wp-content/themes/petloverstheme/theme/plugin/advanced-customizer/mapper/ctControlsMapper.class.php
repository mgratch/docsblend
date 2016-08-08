<?php

/**
 *
 * @author scyzoryck
 */
class ctControlsMapper {

	protected $wp_manager;

	protected $currentPanel = null;

	protected $currentSection = null;

	protected $apply = true;

	protected $controls = array();

	protected $factory;

	protected $variables;

	protected $defaultValues = array();

	protected $priorities = array();

	protected $defaultPriorities = array();


	/**
	 * @param WP_Customize_Manager $wp_manager
	 */
	public function __construct( WP_Customize_Manager $wp_manager, $defaultValuesLink = null, $priorites = array( 'panels'   => 0,
	                                                                                                              'sections' => 0,
	                                                                                                              'controls' => 0
	)
	) {
		if ( ! empty( $defaultValuesLink ) ) {
			$this->importDefaultValues( $defaultValuesLink );
		}
		$this->defaultPriorities = $priorites;
		$this->wp_manager        = $wp_manager;
		$this->factory           = ctControlsFactory::getInstance( $this->wp_manager );

	}


	/**
	 * set current panel. create it if doesn't exists
	 *
	 * @param string $name
	 * @param array $options
	 *
	 * @return $this
	 */
	public function panel( $name, $options = array() ) {

		$id = ( isset( $options['id'] ) ) ? $options['id'] : $this->nameToId( $name );

		/*		if ( ! $this->panelAvailable() ) {
					do_action('ct_customizer_panel_add_' . $id, $this);
					return $this;
				}
		*/
		//panels are supported
		$options['priority'] = ( isset( $options['priority'] ) ) ? $options['priority'] : ( count( $this->priorities ) + $this->defaultPriorities['panels'] );
		if ( $this->panelAvailable() && ! $this->hasPanel( $id ) ) {
			//panel with this name doesn't exist
			$options['title'] = $name;
			$this->wp_manager->add_panel( $id, $options );
			$this->priorities[ $id ] = array();
		}

		$this->currentPanel = $id;
		do_action( 'ct_customizer_panel_add_' . $id, $this );

		return $this;

	}

	/**
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function hasPanel( $id ) {
		$panels = $this->wp_manager->panels();

		return array_key_exists( $id, $panels );
	}

	/**
	 * set current panel as null
	 * @return $this
	 */
	public function endPanel() {
		$this->currentPanel = null;

		return $this;
	}

	/**
	 * set current section. create it if doesn't exists
	 *
	 * @param string $name
	 * @param array $options
	 *
	 * @return $this
	 */
	public function section( $name, $options = array() ) {
		$id = ( isset( $options['id'] ) ) ? $options['id'] : $this->nameToId( $this->currentPanel . $name );

		if ( ! $this->hasSection( $id ) ) {
			//section doesn't exist
			//panel support
			if ( $this->panelAvailable() && ! empty( $this->currentPanel ) ) {
				//panels are supported and add section to panel
				$options['priority']                            = ( isset( $options['priority'] ) ) ? $options['priority'] : ( count( $this->priorities[ $this->currentPanel ] ) + $this->defaultPriorities['sections'] );
				$this->priorities[ $this->currentPanel ][ $id ] = array();
				$options['panel']                               = $this->currentPanel;
			} else {
				//panel is set or supported
				$options['priority']     = ( isset( $options['priority'] ) ) ? $options['priority'] : ( count( $this->priorities ) + $this->defaultPriorities['panels'] );
				$this->priorities[ $id ] = array();
				$panel                   = $this->idToName( $this->currentPanel );
				if ( ! $this->panelAvailable() ) {
					$name = $panel . " - " . $name;
				}
			}

			$options['title'] = $name;

			$this->wp_manager->add_section( $id, $options );
		}

		$this->currentSection = $id;
		do_action( 'ct_customizer_section_add_' . $id, $this );

		return $this;
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 */
	public function hasSection( $id ) {
		$sections = $this->wp_manager->sections();

		return array_key_exists( $id, $sections );

	}

	/**
	 * set current section as null
	 * @return $this
	 */
	public function endSection() {
		$this->currentSection = null;

		return $this;
	}

	/**
	 * alias for add($lessname, 'color', $options)
	 *
	 * @param $lessname
	 * @param $options
	 */
	public function addColor( $lessname, $name, $options ) {
		$this->add( $lessname, $name, 'color', $options );
	}

	/**
	 * add control and setting for less var
	 *
	 * @param string $lessname name of less var
	 * @param string $title
	 * @param string $type type of control. avalaible see in ctControlsfactory class
	 * @param array $options
	 *
	 * @return $this
	 */
	public function add( $lessname, $title, $type = null, $options = array() ) {
		$isLess   = ( isset( $options['is_less'] ) ) ? $options['is_less'] : true;
		$lessname = str_replace( '@', '', $lessname );
		if ( empty ( $this->currentSection ) ) {
			//no section selected - set defalut
			$this->section( esc_html__( 'General', 'ct_theme' ) );
		}

		//we try to get current value - used for legacy implementation where we've just added this feature
		if ( isset( $options['current_value'] ) ) {
			$options['default'] = get_theme_mod( $options['current_value'], false );
		}

		if ( $isLess && ( ! isset( $options['default'] ) || ! $options['default'] ) && isset( $this->defaultValues[ '@' . $lessname ] ) ) {
			$options['default'] = $this->defaultValues[ '@' . $lessname ];
		}

		if ( $isLess ) {
			$settingId = $this->lessnameToId( $lessname );
		} else {
			$settingId = $this->optionToId( $lessname );
		}

		//set section
		$options['section'] = $this->currentSection;

		//add setting
		$options['lessname'] = $lessname;
		if ( $this->panelAvailable() && ! empty( $this->currentPanel ) ) {
			$options['priority']                                                = ( isset( $options['priority'] ) ) ? $options['priority'] : ( count( $this->priorities[ $this->currentPanel ][ $this->currentSection ] ) + $this->defaultPriorities['controls'] );
			$this->priorities[ $this->currentPanel ][ $this->currentSection ][] = $settingId;
		} else {
			$options['priority']                         = ( isset( $options['priority'] ) ) ? $options['priority'] : ( count( $this->priorities[ $this->currentSection ] ) + $this->defaultPriorities['controls'] );
			$this->priorities[ $this->currentSection ][] = $settingId;
		}
		$this->wp_manager->add_setting( $settingId, $options );

		$options['label'] = $title;
		$controlobject    = $this->factory->get( $settingId, $type, $options );

		//add control
		$this->wp_manager->add_control( $controlobject );

		return $this;
	}

	public function option( $lessname, $title, $type = null, $options = array() ) {
		$options['is_less'] = false;

		return $this->add( $lessname, $title, $type, $options );
	}

	/**
	 * get array with variables names as key with value
	 *
	 * @param bool $useCache
	 *
	 * @return array
	 */
	public function getVariables( $useCache = true ) {
		if ( $useCache === false || ! isset( $this->variables ) ) {
			$options = array();
			foreach ( $this->getControls() as $id => $object ) {
				$lessname = $this->idToLessname( $id );
				if ( $lessname === false ) {
					continue;
				}

				$val = get_theme_mod( $id );


				add_filter( 'ct_customizer_value' . $object->type, array( $this->factory, 'filter' ), 10, 2 );
				$val = apply_filters( 'ct_customizer_value' . $object->type, $val, $object );
				if ( $val !== false && ! empty( $val ) ) {
					$options[ $lessname ] = $val;
				}
			}
			$this->variables                 = $options;
			$faPath                          = '/fonts/fontawesome/fonts';
			$faPath                          = apply_filters( 'ct_customizer.fapath', $faPath );
			$this->variables['fa-font-path'] = '"' . CT_THEME_ASSETS . $faPath . '"';
			$this->variables['et-font-path'] = '"' . CT_THEME_ASSETS . '/fonts/et-line-font/fonts"';
			$this->variables['assets-path']  = '"' . CT_THEME_ASSETS . '"';
		}

		return $this->variables;
	}

	protected function importDefaultValues( $path ) {
		$parser = new Less_Parser();
		if ( ! is_callable( array( $parser, 'GetRules' ) ) ) {
			//cannot get Rules from parser
			return;
		}

		$rules = $parser->GetRules( $path );


		$rules = array_filter( $rules, create_function( '$val', 'return isset( $val->variable ) && $val->variable === true;' ) );

		foreach ( $rules as $key => $rule ) {
			$this->defaultValues[ $rule->name ] = $rule->value;
		}
		$this->extractValue( $this->defaultValues );

		array_walk( $this->defaultValues,
			create_function( '&$val', '$val = $val->toCSS();' ) );
	}

	protected function extractArray( &$arg ) {
		if ( $arg instanceof Less_Tree_Value ) {
			$this->extractValue( $arg->value );
		} elseif ( $arg instanceof Less_Tree_Expression ) {
			$this->extractValue( $arg->value );

		} elseif ( $arg instanceof Less_Tree_Call ) {
			$this->extractValue( $arg->args );
			$arg = $arg->compile();
		} elseif ( $arg instanceof Less_Tree_Variable ) {
			$arg = $this->defaultValues[ $arg->name ];
		} elseif ( $arg instanceof Less_Tree_Operation ) {
			$this->extractValue( $arg->operands );
			$arg = $arg->compile( null );
		} elseif ( $arg instanceof Less_Tree_Color ) {

		} elseif ( $arg instanceof Less_Tree_Dimension ) {

		} elseif ( $arg instanceof Less_Tree_Keyword ) {

		} elseif ( $arg instanceof Less_Tree_Quoted ) {

		}
	}

	protected function extractValue( &$array ) {
		array_walk( $array, array( $this, 'extractArray' ) );
	}

	protected function compileVariable( \Less_Tree_Variable $variable ) {
		$name = str_replace( '@', '', $variable->name );
		if ( isset( $this->defaultValues[ $name ] ) ) {
			return $this->defaultValues[ $name ];
		}

		return false;
	}

	protected function getControls() {
		return $this->wp_manager->controls();
	}

	/**
	 * create setting id based on name of less variable
	 *
	 * @param $name
	 *
	 * @return string
	 */
	protected function lessnameToId( $name ) {
		$id = 'ct_customizer_' . str_replace( '-', '_', $name );

		return $id;
	}

	protected function optionToId( $name ) {
		$id = 'ct_option_' . str_replace( '-', '_', $name );

		return $id;
	}

	/**
	 * create name of less variable based on setting id
	 *
	 * @param $id
	 *
	 * @return string
	 */
	protected function idToLessname( $id ) {
		if ( strpos( $id, 'ct_customizer_' ) === 0 && strlen( $id ) > 14 ) {
			$name = substr( $id, 14 );
			$name = str_replace( '_', '-', $name );

			return $name;
		}

		return false;
	}

	/**
	 * create title based on name of less variable
	 *
	 * @param $name
	 *
	 * @return string
	 */
	protected function lessnameToTitle( $name ) {
		$dels = array( $this->currentSection, $this->currentPanel );
		foreach ( $dels as $del ) {
			$del  = str_replace( 'ct_', '', $del );
			$del  = strtolower( $del );
			$name = str_replace( $del, '', $name );
		}
		$name = str_replace( '-', ' ', $name );
		$name = str_replace( '  ', ' ', $name );
		$name = ltrim( $name );
		$name = ucfirst( $name );

		return $name;
	}

	/**
	 * create id based on name
	 *
	 * @param $name
	 *
	 * @return mixed|string
	 */
	protected function nameToId( $name ) {
		$id = strtolower( $name );
		$id = str_replace( ' ', '_', $id );
		$id = 'ct_' . $id;

		return $id;
	}

	/**
	 * if panels are supported by wordpress
	 * @return bool
	 */
	protected function panelAvailable() {
		return version_compare( get_bloginfo( 'version' ), '4.0', '>=' );
	}

	protected function idToName( $id ) {
		$id   = substr( $id, 3 );
		$name = str_replace( '_', ' ', $id );
		$name = ucfirst( $name );

		return $name;
	}
}