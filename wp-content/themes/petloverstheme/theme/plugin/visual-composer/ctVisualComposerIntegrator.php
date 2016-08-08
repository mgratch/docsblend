<?php

if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	/**
	 * Visual Composer integration
	 * @author alex
	 */
	class ctVisualComposerIntegrator {
		/**
		 * Creates integrator
		 */
		public function __construct( $removeDefault = true ) {
			$this->removeDefault = $removeDefault;

			add_action( 'init', array( $this, 'adminInit' ) );
			add_action( 'vc.convert_2_new_version', array( $this, 'convert2NewVersion' ) );
			add_action( 'vc.convert_shortcode.allow_free', array( $this, 'convertShortcodeAllowFree' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

			add_action( 'ct_shortcode_pre_handle', array( $this, 'parseShortcodesAttributes' ), 10, 3 );

			add_filter( 'ct_shortcode.cleanup.shortcode_names', array( $this, 'getShortcodeNamesForCleanup' ) );

			$this->loadClasses();
			if ( apply_filters( 'ct_visual_composer_integrator.disable_frontend', true ) ) {
				vc_disable_frontend();
			}

			//corpress specific. See vc_row.php
			add_filter( 'ct.vc_row.apply_section', array( $this, 'vcRowApplySection' ), 10, 2 );

			add_action( 'admin_print_styles-post.php', array( &$this, 'printAdminStyles' ) );
			add_action( 'admin_print_styles-post-new.php', array( &$this, 'printAdminStyles' ) );

			add_action( 'vc_before_init', array( $this, 'vcBeforeInit' ) );
			add_filter( 'vc_nav_front_logo', array( $this, 'vcNavFrontLogo' ) );
		}

		/**
		 * Custom logo
		 * @return mixed|void
		 */

		public function vcNavFrontLogo() {
			$output = '<a id="vc_logo" class="vc_navbar-brand" title="' . esc_attr( 'Visual Composer', 'ct_theme' )
			          . '" href="http://themeforest.net/user/createit-pl/portfolio?ref=createit-pl" target="_blank">'
			          . esc_html__( 'createIT', 'ct_theme' ) . '</a>';

			return apply_filters( 'ct_visual_composer_integrator.front_logo', $output );
		}

		/**
		 * Handles VC
		 */

		public function vcBeforeInit() {
			vc_set_as_theme( true );
		}

		public function printAdminStyles() {
			$shortcodes = ctShortcodeHandler::getInstance()->getShortcodes();
			echo '<style id="ct-visual-composer">';
			foreach ( $shortcodes as $group => $sh ) {
				foreach ( $sh as $shortcode ) {
					$info = $this->getInfoFromShortcode( $shortcode );
					$name = $shortcode->getShortcodeName();
					if ( $info->getIcon() ) {
						$contentTag = $this->getContentTagFromFont( $info->getIcon() );
						?>
						.vc_element-icon.icon-wpb-vs-<?php echo esc_html( $name ) ?>{
						background-image: none!important;
						}
						.vc_element-icon.icon-wpb-vs-<?php echo esc_html( $name ) ?>:before{
						content: "<?php echo esc_html( $contentTag ) ?>";
						}
						.wpb-layout-element-button .vc_element-icon.icon-wpb-vs-<?php echo esc_html( $name ) ?>{
						top: 8px;
						left: 4px;
						}
					<?php
					}
				}
			}
			echo '</style>';
		}

		/**
		 * Returns tag for field
		 *
		 * @param $class
		 *
		 * @return string
		 */

		protected function getContentTagFromFont( $class ) {

			$helper = new ctFontAwesomeHelper();
			$fonts  = $helper->getFonts();

			return isset( $fonts[ $class ] ) ? $fonts[ $class ]['content'] : '';
		}

		/**
		 * Should we apply row?
		 *
		 * @param $apply
		 * @param $shortcode
		 *
		 * @return bool
		 */

		public function vcRowApplySection( $apply, $shortcode ) {
			if ( get_class( $shortcode ) == 'WPBakeryShortCode_VC_Row' && ! ( is_page_template( 'page-custom.php' ) ) && ! ( is_page_template( 'page-custom-left.php' ) ) ) {
				return true;
			}

			return $apply;
		}

		/**
		 * Return shortcode names to filter <p>
		 *
		 * @param $names
		 *
		 * @return mixed
		 */

		public function getShortcodeNamesForCleanup( $names ) {
			//let filter <p> also from VC
			return array_merge( $names, array_keys( WPBMap::getShortCodes() ) );
		}

		/**
		 * Normalize icompatible shortcode params
		 *
		 * @param $atts
		 * @param $content
		 * @param ctShortcode $shortcode
		 */

		public function parseShortcodesAttributes( $atts, $content, $shortcode ) {
			if ( ! $atts ) {
				return $atts;
			}

			foreach ( $shortcode->getAttributes() as $name => $data ) {
				if ( array_key_exists( $name,
						$atts
				     ) && isset( $data['type'] )
				) {
					$value = $atts[ $name ];

					switch ( $data['type'] ) {
						case 'image':
							$atts[ $name . '_raw' ] = $value;
							//we need to find URL for this image
							if ( $v = $this->getAttachmentImageSrc( $value ) ) {
								$value = $v;
							}

							break;
						case 'images':
							$atts[ $name . '_raw' ] = $value;
							$r                      = array();
							foreach ( explode( ',', $value ) as $e ) {
								$r[] = $this->getAttachmentImageSrc( $e );
							}
							$r = array_filter( $r );
							if ( $r ) {
								$value = implode( ',', $r );
							}
					}

					$atts[ $name ] = $value;
				}
			}


			return $atts;
		}

		/**
		 * Adds dynamic parameters ex. for images
		 *
		 * @param array $atts
		 */

		public function normalizeAttributesFilter( $atts ) {
			foreach ( $atts as $name => $data ) {
				if ( ! isset( $data['type'] ) ) {
					$data['type'] = 'text';
				}
				switch ( $data['type'] ) {
					case 'image':
					case 'images':
						$atts[ $name . '_raw' ] = $data;
				}
			}

			return $atts;
		}

		/**
		 * Attachment image
		 *
		 * @param $value
		 *
		 * @return string
		 */

		protected function getAttachmentImageSrc( $value ) {
			if ( is_numeric( $value ) ) {
				$data = wp_get_attachment_image_src( $value, 'full' );
				if ( $data && isset( $data[0] ) ) {
					$value = $data[0];
				}

				return $value;
			}

			return '';
		}

		public function admin_scripts() {
			$font     = '/fontawesome/css/font-awesome.min.css';
			$font = apply_filters('ct.cs_font_awesome_path',$font);
//			$filePath = CT_THEME_DIR . '/assets' . $font;
//			//if not available - fallback to standard external version
//			if ( ! file_exists( $filePath ) ) {
//				$filePath = '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css';
//			} else {
				$filePath = CT_THEME_ASSETS . $font;
//			}

			wp_enqueue_style( 'ct.cs_font_awesome', $filePath );
			wp_enqueue_style( 'ct.vs_admin_styles', CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/visual-composer/assets/css/admin.css', array( 'ct.cs_font_awesome' ) );
		}

		/**
		 * Do we allowo element outside row?
		 *
		 * @param $name
		 *
		 * @return bool
		 */

		public function convertShortcodeAllowFree( $name ) {
			$allowed = array( 'full_width' => 1, 'spacer' => 1 );

			return isset( $allowed[ $name ] );
		}

		/**
		 * Transforms columns and rows
		 *
		 * @param $content
		 *
		 * @return mixed|string
		 */

		public function convert2NewVersion( $content ) {
			$maps = array(
				'[row'   => '[vc_row',
				'[/row]' => '[/vc_row]',
			);

			$content = strtr( $content, $maps );

			$columns = array(
				'full_column'      => '1/1',
				'half_column'      => '1/2',
				'third_column'     => '1/3',
				'quarter_column'   => '1/4',
				'one_sixth_column' => '1/6"'
			);

			foreach ( $columns as $name => $w ) {
				$content = str_replace( '[' . $name . '', '[vc_column width="' . $w . '" ', $content );
				$content = str_replace( '[/' . $name . ']', '[/vc_column]', $content );
			}

			return $content;
		}

		/**
		 * Handles default form types
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return String
		 */
		public function genericHandler( $settings, $value ) {
			$d                 = new ctShortcodeDecorator( null );
			$settings['label'] = ''; //we already have a label displayed by vs
			$element           = $d->getFormElementByType( $settings['type'], $settings['param_name'], $settings );
			if ( ! $element ) { //hidden elements have type - false
				return '';
			}

			return $element->toString();
		}

		/**
		 * Returns shortcode names we do not need
		 */

		protected function getDefaultUnwantedShortcodes() {
			$unwanted = array(
				'vc_accordion_tab',
				'vc_accordion',
				'vc_button',
				'vc_cta_button',
				//'vc_separator',
				'vc_text_spearator',
				'vc_message',
				'vc_toggle',
				'vc_widget_sidebar',
				'vc_gallery',
				'vc_single_image',
				'vc_video',
				'vc_gmaps',
				'vc_posts_slider',
				'vc_twitter',
				'vc_facebook',
				'vc_googleplus',
				'vc_pinterest',
				'vc_flickr',
				//'vc_tab',
				//'vc_tabs',
				//'vc_teaser_grid',
				'vc_tour',
				'vc_tweetmeme'
			,
				'my_hello_world',
				//'vc_tab'
			);

			//your filter may just return empty array so that all default widgets will be visible
			return apply_filters( 'ct_visual_composer_integrator.unwanted_shortcodes', $unwanted );
		}

		/**
		 * Unwanted groups
		 * @return mixed|void
		 */

		protected function getDefaultUnwantedThemeGroups() {
			$unwanted = array( 'Structure' );

			return apply_filters( 'ct_visual_composer_integrator.unwanted_shortcode_groups', $unwanted );
		}

		/**
		 * Find admin labels
		 *
		 * @param array $attrs
		 *
		 * @return array
		 */

		protected function findAdminLabels( $attrs ) {
			$labs = array();
			//false - allow to add more params, true - stop here
			$fields = array(
				'name'      => false,
				'title'     => false,
				'header'    => false,
				'subheader' => false,
				'text'      => false,
				'legend'    => false,
				'value'     => false
			);
			foreach ( $attrs as $label => $v ) {
				if ( array_key_exists( $label, $fields ) ) {
					$labs[ $label ] = 1;

					if ( $attrs[ $label ] ) {
						break;
					}
				}
			}

			return $labs;
		}

		/**
		 * Returns parameters translated for VS
		 *
		 * @param ctShortcode $shortcode
		 *
		 * @return array
		 */
		protected function getNormalizedParams( $shortcode, $group = '' ) {
			$params = array();

			$attributes = $shortcode->getAttributesNormalized();
			$info       = $this->getInfoFromShortcode( $shortcode );

			if ( $info === null ) {
				throw new Exception( "Shortcode " . $shortcode->getShortcodeName() . ' must return VisualComposerInfo instance!' );
			}

			$adminLabels = $info->getAdminLabels() ? array_flip( $info->getAdminLabels() ) : $this->findAdminLabels( $attributes );

			foreach ( $attributes as $attrName => $attr ) {
				$data = $this->normalizeSingleParam( $attrName, $attr, $adminLabels, $group );

				//skip for container
				if ( $attrName == 'content' && ( $info->isContainer() || $shortcode->getChildShortcode() ) ) {
					continue;
				}

				if ( $data ) {
					$params[] = $data;
				}
			}

			return $params;
		}

		/**
		 * Normalize single param
		 *
		 * @param $attrName
		 * @param $attr
		 *
		 * @param array $adminLabels
		 * @param string $group
		 *
		 * @param ctVisualComposerInfo $info
		 *
		 * @throws Exception
		 * @return array
		 */

		protected function normalizeSingleParam( $attrName, $attr, $adminLabels = array(), $group = '' ) {
			if ( ! isset( $attr['type'] ) ) {
				$attr['type'] = 'input';
			}

			if ( ! is_array( $attr ) ) {
				throw new Exception( "VC Integrator: attr should be an array. Got: " . $attr . ', attrName: ' . $attrName . '. Please make sure that shortcode.getAttributes have all required bracekts!' );
			}

			$type = $attr['type'];

			//hidden field
			if ( $type === false ) {
				return false;
			}

			$mapType = array(
				'icon'          => 'icon',
				'input'         => "textfield",
				'textarea'      => 'textarea',
				'select'        => 'dropdown',
				'multiselect'   => "textfield", //@todo
				'colorpicker'   => 'colorpicker',
				'image'         => 'attach_image',
				'images'        => 'attach_images',
				'toggable'      => '',
				'checkbox'      => 'checkbox',
				'select_switch' => 'select_switch',
			);

			//we do not have/support this type
			if ( ! isset( $mapType[ $type ] ) || $mapType[ $type ] === true ) {
				if (function_exists('vc_add_shortcode_param')){
					vc_add_shortcode_param( $attr['type'], array( $this, 'genericHandler' ) );
				}else{
					add_shortcode_param( $attr['type'], array( $this, 'genericHandler' ) );
				}
			}

			if ( array_key_exists( 'value', $attr ) ) {
				$value = $attr['value'];
			} else {
				$value = array_key_exists( 'default', $attr ) ? $attr['default'] : '';
			}


			if ( isset( $attr['choices'] ) ) {
				$value = $this->flipArray( $attr['choices'], $value );
				unset( $attr['choices'] );
			}

			if ( isset( $attr['options'] ) ) {
				$value = $this->flipArray( $attr['options'], $value );
				unset( $attr['options'] );
			}

			$finalType = isset( $mapType[ $type ] ) ? $mapType[ $type ] : $type;

			$data = array(
				'type'        => $finalType,
				'holder'      => 'hidden',
				'heading'     => isset( $attr['label'] ) ? ucfirst( $attr['label'] ) : ucfirst( $attrName ),
				'param_name'  => $attrName,
				'value'       => $value,
				'description' => array_key_exists( 'help', $attr ) ? $attr['help'] : '',
			);

			if ( isset( $attr['group'] ) ) {
				$data['group'] = $attr['group'];
			} else if ( $group ) {
				$data['group'] = $group;
			}

			//special case
			if ( $attrName == 'content' ) {
				$data['type']   = 'textarea_html';
				$data['holder'] = 'div'; //to display content
			}

			if ( $type == 'checkbox' ) {
				$data['type']  = 'checkbox';
				$data['value'] = array( $data['heading'] => $value );
			}


			if ( isset( $adminLabels[ $attrName ] ) ) {
				$data['admin_label'] = true;
			}

			if ( isset( $attr['dependency'] ) ) {
				$data['dependency'] = $attr['dependency'];
			}

			//add any other custom params so plugins can extend it easily
			$data = array_merge( $attr, $data );


			return $data;
		}

		/**
		 * Load base classes
		 */

		protected function loadClasses() {
			ctThemeLoader::getFilesLoader()->requireOnce(CT_THEME_PLUGINS . '/visual-composer/ctVisualComposerWrapperShortcode.php' );
			ctThemeLoader::getFilesLoader()->requireOnce( CT_THEME_PLUGINS . '/visual-composer/ctVisualComposerCollectionWrapperShortcode.php' );
			ctThemeLoader::getFilesLoader()->includeOnceByPattern( CT_THEME_PLUGINS . '/visual-composer/*.php' );
		}

		/**
		 * Flip array
		 *
		 * @param $array
		 *
		 * @return array
		 */

		protected function flipArray( $array, $default = '' ) {
			$e = array();
			foreach ( $array as $k => $v ) {
				if ( is_array( $v ) ) {
					foreach ( $v as $group => $data ) {
						foreach ( $data as $a => $aa ) {
							$e[ $group . ' - ' . $aa ] = $a;
						}
					}
				} else {
					$e[ $v ] = $k;
				}
			}

			//add first element to make it default. VC doesn't have a default parameter
			if ( ( $index = array_search( $default, $e ) ) ) {
				unset( $e[ $index ] );
				$e           = array_reverse( $e, true );
				$e[ $index ] = $default;
				$e           = array_reverse( $e, true );
			}


			return $e;
		}


		/**
		 * Inits visual composer shortcodes
		 */

		public function adminInit() {
			$vcShortcodes = $this->getDefaultUnwantedShortcodes();

			if (function_exists('vc_remove_element')) {
				foreach ($vcShortcodes as $sh) {
					vc_remove_element($sh);
				}
			} else {
				foreach ($vcShortcodes as $sh) {
					wpb_remove($sh);
				}
			}


			$shortcodes = ctShortcodeHandler::getInstance()->getShortcodes();

			$unwantedGroups = $this->getDefaultUnwantedThemeGroups();

			foreach ( $unwantedGroups as $group ) {
				if ( isset( $shortcodes[ $group ] ) ) {
					unset( $shortcodes[ $group ] );
				}

				if ( isset( $shortcodes[ strtolower( $group ) ] ) ) {
					unset( $shortcodes[ strtolower( $group ) ] );
				}
			}

			foreach ( $shortcodes as $groupName => $items ) {
				if ( $groupName == 'Internal' ) {
					continue;
				}

				/** @var $s ctShortcode */
				foreach ( $items as $s ) {
					$info = $this->getInfoFromShortcode( $s );

					$options = array(
						"name"        => $s->getName(),
						"base"        => $s->getShortcodeName(),
						"class"       => "",
						'description' => $info->getDescription(),
						'icon'        => 'icon-wpb-vs-' . $s->getShortcodeName(),
						"category"    => $s->getGroupName(),
						"params"      => $this->getNormalizedParams( $s )
					);


					//add and register shortcode
					self::getWrapperForShortcode( $s, $options );
				}
			}


			$this->expandBaseShortcodes();

			//remove generator info
			remove_action( 'wp_head', array( visual_composer(), 'addMetaData' ) );

			ctShortcode::connectNormalizedAttributesFilter( '', array( $this, 'normalizeAttributesFilter' ) );
		}

		/**
		 * Expand base shortcode
		 */

		protected function expandBaseShortcodes() {
			$this->addBaseShortcodeParam( 'vc_column', array(
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Full width', 'ct_theme' ),
					'param_name'  => 'full_width',
					'description' => esc_html__( "If selected, elements inside will expand to full site width. Works only for 1/1 column", 'ct_theme' ),
					'value'       => array( esc_html__( 'Yes, make it a full width element', 'ct_theme' ) => 'yes' ),
				),
				array(
					'type'        => "dropdown",
					'param_name'  => "align",
					'heading'     => esc_html__( "Text alignment", 'ct_theme' ),
					'value'       => array(
						esc_html__( "Left", 'ct_theme' )   => "",
						esc_html__( "Center", 'ct_theme' ) => "center",
						esc_html__( "Right", 'ct_theme' )  => "right"
					),
					'description' => esc_html__( "Select text alignment", 'ct_theme' ),
				)
			) );

			//add js responsivness
			$this->addBaseShortcodeParam( 'vc_column_inner', array(
				array(
					'type'        => 'column_offset',
					'heading'     => esc_html__( 'Responsiveness', 'ct_theme' ),
					'param_name'  => 'offset',
					'group'       => esc_html__( 'Width & Responsiveness', 'ct_theme' ),
					'description' => esc_html__( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'ct_theme' )
				)
			) );

			//extend existing VC shortcodes
			$extensions = apply_filters( 'ct_visual_composer_integrator.expand_base_shortcodes', array() );
			foreach ( $extensions as $name => $params ) {
				if ( ! isset( $params['params'] ) && ! isset( $params['shortcode'] ) ) {
					throw new Exception( "$name should have params or shortcode key!" );
				}
				$append = isset( $params['options']['append'] ) ? $params['options']['append'] : false;

				//manual entry - NOTE that these params should be VC compatible!
				if ( isset( $params['params'] ) ) {
					$this->addBaseShortcodeParam( $name, $params['params'], $append );
				} elseif ( isset( $params['shortcode'] ) ) {
					//automatically add params from shortcode
					$this->addBaseShortcodeParam( $name, $this->getNormalizedParams( $params['shortcode'], $params['group'] ), $append );
				}
			}
		}

		/**
		 * Adds shortcode to base shortcodes ie. existing VC shortcodes
		 *
		 * @param $name
		 * @param $params
		 * @param bool $append
		 *
		 * @throws Exception
		 */

		protected function addBaseShortcodeParam( $name, $params, $append = false ) {
			$e        = WPBMap::getShortCode( $name );
			$settings = isset($e['params']) && is_array($e['params'])?$e['params']:array();

			if ( $append ) {
				$settings = array_merge( $params, $settings );
			} else {
				$settings = array_merge( $settings, $params );
			}

			//apply custom filters
			$pluginsSettings = apply_filters( ctShortcode::getFilterName( $name, ctShortcode::FILTER_NORMALIZED_ATTRIBUTES ), array() );

			$adminLabels = $this->findAdminLabels( $settings );
			foreach ( $pluginsSettings as $key => $val ) {
				if ( $e = $this->normalizeSingleParam( $key, $val, $adminLabels ) ) {
					$pluginsSettings[ $key ] = $e;
				} else {
					unset( $settings[ $key ] );
				}
			}

			$settings = array_merge( $settings, $pluginsSettings );

			WPBMap::modify( $name, 'params', $settings );
		}

		/**
		 * Returns info from shortcode
		 *
		 * @param $shortcode
		 *
		 * @return ctVisualComposerInfo
		 */

		protected static function getInfoFromShortcode( $shortcode ) {
			return $shortcode instanceof ctVisualComposerShortcodeInterface ? $shortcode->getVisualComposerInfo() : new ctVisualComposerInfo( $shortcode );
		}

		/**
		 * Return wrapper
		 *
		 * @param ctShortcode $shortcode
		 * @param $options
		 *
		 * @internal param bool $collection
		 */

		protected static function getWrapperForShortcode( $shortcode, $options ) {
			$name = get_class( $shortcode ) . 'VS';
			$info = self::getInfoFromShortcode( $shortcode );

			//maybe sepcialized class?
			if ( class_exists( $name ) ) {
				new $name( $shortcode, $options );
			} elseif ( $shortcode->getChildShortcode() || $info->isContainer() ) {
				new ctVisualComposerCollectionWrapperShortcode( $shortcode, $options );
			} else {
				new ctVisualComposerWrapperShortcode( $shortcode, $options );
			}
		}
	}

	new ctVisualComposerIntegrator();

	$dir = get_stylesheet_directory() . '/vc_templates/';
	//for child themes make sure we have directory. If not - use parent
	if ( is_child_theme() ) {
		if ( ! file_exists( $dir ) ) {
			$dir = get_template_directory() . '/vc_templates/';
		}
	}
	vc_set_shortcodes_templates_dir( $dir );

	/**
	 * Inject additional parameters
	 *
	 * @param $eventName
	 * @param array $params
	 * @param array $atts
	 *
	 * @return string
	 */

	function ct_vc_container_attributes( $shortcodeName, $params = array(), $atts = array() ) {
		$params    = apply_filters( ctShortcode::getFilterName( $shortcodeName, ctShortcode::FILTER_INLINE_ATTRIBUTE ), $params, $atts );
		$delimiter = ' ';
		$r         = '';
		foreach ( $params as $key => $val ) {
			if ( is_array( $val ) ) {
				foreach ( $val as $k => $v ) {
					if ( $v === '' ) {
						unset( $val[ $k ] );
					}
				}
				$val = implode( ' ', $val );
			}
			if ( $val !== '' ) {
				$r .= ( $key . '="' . esc_attr( $val ) . '" ' );
			}
		}
		return $delimiter . trim( $r );
	}


	/*
	 * Legacy functions
	 *
	 */


	if (!function_exists('ct_vc_column_build_style')) {
		function ct_vc_column_build_style($font_color = '')
		{
			$style = '';
			if (!empty($font_color)) {
				$style .= vc_get_css_color('color', $font_color);
			}

			return empty($style) ? $style : ' style="' . esc_attr($style) . '"';
		}
	}


	if (!function_exists('ct_get_row_css_class')) {
		function ct_get_row_css_class()
		{
			$custom = vc_settings()->get('row_css_class');

			return !empty($custom) ? $custom : 'vc_row-fluid';
		}
	}


	if (!function_exists('ct_vc_row_build_style')) {
		function ct_vc_row_build_style($bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding = '', $margin_bottom = '')
		{
			$has_image = false;
			$style = '';
			if ((int)$bg_image > 0 && ($image_url = wp_get_attachment_url($bg_image, 'large')) !== false) {
				$has_image = true;
				$style .= "background-image: url(" . $image_url . ");";
			}
			if (!empty($bg_color)) {
				$style .= vc_get_css_color('background-color', $bg_color);
			}
			if (!empty($bg_image_repeat) && $has_image) {
				if ('cover' === $bg_image_repeat) {
					$style .= "background-repeat:no-repeat;background-size: cover;";
				} elseif ('contain' === $bg_image_repeat) {
					$style .= "background-repeat:no-repeat;background-size: contain;";
				} elseif ('no-repeat' === $bg_image_repeat) {
					$style .= 'background-repeat: no-repeat;';
				}
			}
			if (!empty($font_color)) {
				$style .= vc_get_css_color('color', $font_color);
			}
			if ($padding !== '') {
				$style .= 'padding: ' . (preg_match('/(px|em|\%|pt|cm)$/', $padding) ? $padding : $padding . 'px') . ';';
			}
			if ($margin_bottom !== '') {
				$style .= 'margin-bottom: ' . (preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom . 'px') . ';';
			}

			return empty($style) ? '' : ' style="' . esc_attr($style) . '"';
		}
	}



}
