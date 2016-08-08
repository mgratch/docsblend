<?php
$output = $font_color = $el_class = $width = $offset = $full_width = $align = '';
extract( shortcode_atts( array(
	'font_color' => '',
	'el_class'   => '',
	'width'      => '1/1',
	'css'        => '',
	'offset'     => '',
	'align'      => '',
	'full_width' => 0,
	''
), $atts ) );

if ( $full_width === 'yes' || $full_width == 1 ) {
	echo '</div></div>';
	echo wpb_js_remove_wpautop( $content );
	echo '<div class="container"><div class="row">';
} else {
	$align     = $align ? ' text-' . $align : '';
	$el_class  = $this->getExtraClass( $el_class );
	$width     = wpb_translateColumnWidthToSpan( $width );
	$width     = str_replace( 'vc_col-', 'col-', vc_column_offset_class_merge( $offset, $width ) );
	$style     = $this->buildStyle( $font_color );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ) . $align, $this->settings['base'], $atts );
	$output .= "\n\t" . '<div' . ct_vc_container_attributes( 'vc_column', array(), $atts ) . ' class="' . $css_class . '"' . $style . '>';
	$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
	$output .= "\n\t" . '</div>';
	echo $output;
}
