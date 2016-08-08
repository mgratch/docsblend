<?php


	$sections[] = array(
		'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_118_embed_close.png',
		'title' => __('Custom styles', 'ct_theme'),
		'group' => __("Code", 'ct_theme'),
		'fields' => array(
			array(
				'id' => "code_custom_styles_css",
				'title' => __('Custom CSS', 'ct_theme'),
				'type' => "textarea",
			),
			array(
				'id' => "code_custom_styles_js",
				'title' => __('Custom Javascript', 'ct_theme'),
				'desc' => __("ex. custom tracking code. ", 'ct_theme'),
				'type' => "textarea"
			),
		)
	);