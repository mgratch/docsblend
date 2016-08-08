<?php

/**
 * List item shortcode
 */
class ctListSimpleItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Simple Item';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_simple_item';
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



$var1 = ctListSimpleShortcode::$type;


		if($open_new_tab=='yes'){
			$tab = 'target="_blank"';
		}else
			$tab='';



		switch($var1){
			case 'ordered':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}
				break;

			case 'ordered_bold':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;

			case 'unordered':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;

			case 'unordered_bold':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;


			case 'no_bullets':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;

			case 'no_bullets_bold':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;


			case 'inline':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;
			case 'inline_bold':
				if ($link == '') {
					return do_shortcode(' <li>' . $content . '</li>');
				}else{
					return do_shortcode(' <li><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}				break;




			case 'list_group':

				if ($link == '') {
					return do_shortcode(' <li class="list-group-item">' . $content . '</li>');
				}else{
					return do_shortcode(' <li class="list-group-item"><a href="'.$link.'" '.$tab.'>' . $content . '</a></li>');
				}
				break;

			case 'list_group_bold':
				if ($link == '') {
					return do_shortcode(' <li class="list-group-item">' . $content . '</li>');
				}else{
					return do_shortcode(' <li class="list-group-item"><a href="'.$link.'"  '.$tab.'>' . $content . '</a></li>');
				}
				break;




			case 'list_group_with_badges':
				return do_shortcode('<li class="list-group-item  '.$style.'"><span class="badge">'.$x.'</span>' . $content . '</li>');
				break;

			case 'list_group_with_badges_bold':
				return do_shortcode('<li class="list-group-item  '.$style.'"><span class="badge">'.$x.'</span>' . $content . '</li>');
				break;


			case 'list_group_headings':
				if ($link == '') {
					return do_shortcode(' <a class="list-group-item ' . $style . '">
             								<h4 class="list-group-item-heading">' . $title . '</h4>
									                <p class="list-group-item-text">' . $content . '</p>
            </a>');
				}else{

					return do_shortcode(' <a href="' . $link . '" ' . $tab . ' class="list-group-item ' . $style . '">
             								<h4 class="list-group-item-heading">' . $title . '</h4>
									                <p class="list-group-item-text">' . $content . '</p>
            </a>');
				}
				break;

		}

	}

	/**
	 * @return string
	 */
	public function getParentShortcodeName() {
		return 'list_simple';
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

			'x'                                           => array(
				'label'   => __( 'Badge (available only on Badges formats)', 'ct_theme' ),
				'default' => '',
				'type'    => "input"
			),

			'title'                                           => array(
				'label'   => __( 'Title (available only on headings formats)', 'ct_theme' ),
				'default' => '',
				'type'    => "input"
			),

			'style' => array('label' => __('Style (available only on List group with badges/headings formats)', 'ct_theme'), 'default' => '', 'type' => 'select', 'choices' =>
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

new ctListSimpleItemShortcode();