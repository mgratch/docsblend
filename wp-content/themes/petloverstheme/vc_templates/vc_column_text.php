<?php
$output = $el_class = $css_animation = $full_width = '';

extract( shortcode_atts( array(
	'el_class'      => '',
	'css_animation' => '',
	'css'           => '',
	'full_width'    => 0
), $atts ) );
if ( $full_width === 'yes' || $full_width == 1 ) {
	echo '</div></div>';
	echo wpb_js_remove_wpautop( $content );//no escape required
	echo '<div class="container">';
} else {
	$el_class = $this->getExtraClass( $el_class );

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	$css_class .= $this->getCSSAnimation( $css_animation );
	$output .= "\n\t" . '<div class="' . $css_class . '">';
	$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content, true );
	$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_text_column' );

	echo $output;//no escape required
}