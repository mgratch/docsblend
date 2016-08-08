<?php

/**
 * List item shortcode
 */
class ctListIconItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Icon Item';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_icon_item';
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



$var1 = ctListIconShortcode::$type;


		if($open_new_tab=='yes'){
			$tab = 'target="_blank"';
		}else
			$tab='';

//var_dump(ctListIconShortcode::$type);

		switch($var1){


			case 'simple':
				if ($link == '') {
					return do_shortcode(' <li><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					' . $content . '
					</li>
					 ');
				}else{
					return do_shortcode(' <li><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					<a href="'.$link.'" '.$tab.'>' . $content . '</a>
					</li>');
				}
				break;

			case 'simple_bold':
				if ($link == '') {
					return do_shortcode(' <li><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					' . $content . '
					</li>
');
				}else{
					return do_shortcode(' <li><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					<a href="'.$link.'" '.$tab.'>' . $content . '</a>
					</li>');
				}
				break;



			case 'fancy_container':

				//var_dump($shape);

				if($shape=='1'){
					return do_shortcode('<li>

					<span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					<i class="fa '.$icon.' fa-stack-1x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).'></i>
					</span>	'.$content.'</li>');

				}if($shape =='2'){
				return do_shortcode('<li>
				<span class="fa-stack fa-lg">
				<i class="fa fa-square fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
				<i class="fa '.$icon.' fa-stack-1x fa-inverse "></i>
				</span>'.$content.'</li>');

			}else{
				return do_shortcode('<li>
				<span class="fa-stack fa-lg">
				<i class="fa fa-circle fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
				<i class="fa '.$icon.' fa-stack-1x fa-inverse " ></i>
				</span>	'.$content.'</li>');			}
				break;


			case 'list_group_simple':
				if ($link == '') {
					return do_shortcode(' <li class="list-group-item"><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					' . $content . '
					</li>
					 ');
				}else{
					return do_shortcode(' <li class="list-group-item"><i class="fa fa-fw '.$icon.' ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					<a href="'.$link.'" '.$tab.'>' . $content . '</a>
					</li>');
				}
				break;


			case 'list_group':

				if($shape=='1'){
					return do_shortcode('<li class="list-group-item '.$style.'">

					<span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
					<i class="fa '.$icon.' fa-stack-1x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).'></i>
					</span>	'.$content.'</li>');


				}if($shape =='2'){
				return do_shortcode('<li class="list-group-item '.$style.'"><span class="fa-stack fa-lg">
				<i class="fa fa-square fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
				<i class="fa '.$icon.' fa-stack-1x fa-inverse "></i>
				</span>'.$content.'</li>');

			}else{
				return do_shortcode('<li class="list-group-item '.$style.'"><span class="fa-stack fa-lg">
				<i class="fa fa-circle fa-stack-2x ct-js-color" ' .ct_esc_attr('data-color', str_replace('#', '', $icon_color)).' ></i>
				<i class="fa '.$icon.' fa-stack-1x fa-inverse " ></i>
				</span>	'.$content.'</li>');
			}
				break;

		}

	}

	/**
	 * @return string
	 */
	public function getParentShortcodeName() {
		return 'list_icon';
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
				'type'    => "input"
			),

			'icon'            => array(
				'label'   => __( 'Icon', 'ct_theme' ),
				'type'    => "icon",
				'font_types'=>array('awesome','etline'),
				'default' => '',
				'link'    => CT_THEME_ASSETS . '/shortcode/awesome/index.html'
			),
			'icon_color'      => array(
				'label'   => __( 'Color', 'ct_theme' ),
				'type'    => "colorpicker",
				'default' => '#1f8bf3'
			),

			'link'                                           => array(
				'label'   => __( 'Link', 'ct_theme' ),
				'default' => '',
				'type'    => "input"
			),

			'open_new_tab' => array('label' => __('Open on new tab', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' =>
				array(
					'no' => __('no', 'ct_theme'),
					'yes' => __('yes', 'ct_theme'),
				)),


			'shape' => array(
				'label' => __('Shape (avaiable on fancy and list group)', 'ct_theme'),
				'default' => '1',
				'type' => 'select',
				'options' =>array(
					'1' => __('Border Container', 'ct_theme'),
					'2' => __('Inverse Container', 'ct_theme'),
					'3' => __('Circle Container', 'ct_theme'),
				),

			),
			'style' => array('label' => __('Style (available only on List group )', 'ct_theme'), 'default' => '', 'type' => 'select', 'choices' =>
				array(
					'' => __('none', 'ct_theme'),
					'list-group-item-warning' => __('warning', 'ct_theme'),
					'list-group-item-success' => __('success', 'ct_theme'),
					'list-group-item-info' => __('info', 'ct_theme'),
					'list-group-item-danger' => __('danger', 'ct_theme'),
					'active' => __('active', 'ct_theme'),

				)),



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

new ctListIconItemShortcode();