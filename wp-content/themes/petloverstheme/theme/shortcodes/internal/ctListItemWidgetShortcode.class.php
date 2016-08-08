<?php

/**
 * List item shortcode
 */
class ctListItemWidgetShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Item Widget';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_itemwidget';
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



		if($link==''){

			return do_shortcode( ' <li><div class="ct-listTable"><div class="ct-ListDiamond"><i class="'.$choose_icon.'"></i></div></div><span>'.$content.'</span></li>' );

		}else{
			return do_shortcode( ' <li><a href="'.$link.'"><div class="ct-listTable"><div class="ct-ListDiamond"><i class="'.$choose_icon.'"></i></div></div><span>'.$content.'</span></a></li>' );

		}


	}

	/**
	 * @return string
	 */
	public function getParentShortcodeName() {
		return 'listWidget';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$items = array();

			$items['content'] = array(
				'label'   => __( 'Content', 'ct_theme' ),
				'default' => '',
				'type'    => "textarea"
			);

			$items['link']= array(
				'label'   => __( 'Link', 'ct_theme' ),
				'default' => '',
				'type'    => "textarea"
			);


			$items['choose_icon'] = array(
				'label' => __("icon", 'ct_theme'),
				'default' => 'fa fa-chevron-right',
				 'type' => 'select',
            'options' => array(
                'fa fa-chevron-right' => 'default',
				'fa fa-facebook' => 'facebook',
				'fa fa-twitter' => 'twitter',
				'fa fa-rss' => 'rss',
				'fa fa-linkedin' => 'linkedin',
				'fa fa-home' => 'home',
				'fa fa-envelope' => 'envelope',
                'fa fa-phone' => 'phone'),

			);


return $items;
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon'        => 'fa-list',
			'description' => __( "Add single list item", 'ct_theme' )
		) );
	}
}

new ctListItemWidgetShortcode();