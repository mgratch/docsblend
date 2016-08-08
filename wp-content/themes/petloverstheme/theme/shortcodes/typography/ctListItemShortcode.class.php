<?php

/**
 * List item shortcode
 */
class ctListItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Item';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_item';
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





		if($icon==''){
			$i ='fa-chevron-right';
		}else{
			$i = $icon;
		}

		if($open_new_tab=='yes'){
			$tab = 'target="_blank"';
		}else
			$tab='';




		if(ctListShortcode::$type=='default') {

			if ($link == '') {

				return do_shortcode(' <li><div class="ct-listTable"><div class="ct-ListDiamond"><i class="fa '.$i.'"></i></div></div><span>' . $content . '</span></li>');

			} else {
				return do_shortcode(' <li><a href="' . $link . '" '.$tab.'><div class="ct-listTable"><div class="ct-ListDiamond"><i class="fa '.$i.'"></i></div></div><span>' . $content . '</span></a></li>');

			}
		}

		else{


			if ($link == '') {

				return do_shortcode(' <li><i class="fa '.$i.'"></i>' . $content . '</li>');

			} else {
				return do_shortcode(' <li><a href="' . $link . ' '.$tab.'"><i class="fa '.$i.'"></i><span>' . $content . '</span></a></li>');

			}



		}

	}

	/**
	 * @return string
	 */
	public function getParentShortcodeName() {
		return 'list';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$items = array(

			'content'                                           => array(
				'label'   => __( 'Content', 'ct_theme' ),
				'default' => '',
				'type'    => "textarea"
			),
			'link'                                           => array(
				'label'   => __( 'Link', 'ct_theme' ),
				'default' => '',
				'type'    => "textarea"
			),


			'open_new_tab' => array('label' => __('Open on new tab', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' =>
				array(
					'no' => __('no', 'ct_theme'),
					'yes' => __('yes', 'ct_theme'),
				)),

			'icon' => array('label' => __('Icon', 'ct_theme')
			, 'type' => "icon", 'default' => '',
				'link' => CT_THEME_ASSETS . '/shortcode/awesome/index.html',
				),

			'class'                                             => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'type'    => 'input',
				'default' => '',
				'help'    => __( "Set custom class to element", 'ct_theme' )
			),

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

new ctListItemShortcode();