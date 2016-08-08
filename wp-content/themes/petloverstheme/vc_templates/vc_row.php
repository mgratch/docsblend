<?php
$output  = $el_class = $font_color = $padding = $margin_bottom = $css = '';
$section = ctShortcodeHandler::getInstance()->getShortcode( 'section' );

extract( shortcode_atts( array(
	'el_class'      => '',
	'font_color'    => '',
	'padding'       => '',
	'margin_bottom' => '',
	'css'           => ''
), $atts ));

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$style = $this->buildStyle( '', '', '', $font_color, $padding, $margin_bottom );
$output .= '<div'.ct_vc_container_attributes( 'vc_column', array(), $atts ).' class="' . $css_class . '"' . $style . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>' . $this->endBlockComment( 'row' );
if ( apply_filters('ct.vc_row.apply_section',false,$this) ) {
	echo '</div>'.$section->handleShortcode( $atts, $output ).'<div class="container">';
	//echo '<div class="container">';
} else {
	echo $output;
	//echo '<div class="container">';
}
