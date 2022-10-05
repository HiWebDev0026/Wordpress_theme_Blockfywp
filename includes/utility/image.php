<?php

declare( strict_types=1 );

namespace Blockify\Theme;

/**
 * Returns placeholder HTML element string.
 *
 * @since 1.0.0
 *
 * @param string $html       Block content.
 * @param array  $attributes Block attributes.
 *
 * @return string
 */
function get_image_placeholder( string $html, array $attributes = [] ): string {
	$html        = ! $html ? '<figure class="wp-block-image"><img src="" alt=""/></figure>' : $html;
	$dom         = dom( $html );
	$figure      = get_dom_element( 'figure', $dom );
	$styles      = css_array_to_string( add_block_support_color( [], $attributes ) );
	$svg         = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" preserveAspectRatio="none" class="wp-block-image__placeholder" style="' . $styles . '"><path vector-effect="non-scaling-stroke" d="M60 60 0 0"></path></svg>';
	$svg_dom     = dom( $svg );
	$svg_element = get_dom_element( 'svg', $svg_dom );
	$result      = $dom->importNode( $svg_element, true );
	$img         = get_dom_element( 'img', $figure );

	if ( $img ) {
		$figure->removeChild( $img );
	}

	if ( $figure ) {
		$figure->appendChild( $result );
		$figure->setAttribute( 'class', $figure->getAttribute( 'class' ) . ' is-placeholder' );

		$css = [
			'width'         => $attributes['width'] ?? '',
			'height'        => $attributes['height'] ?? '',
			'margin-top'    => $attributes['style']['spacing']['margin']['top'] ?? '',
			'margin-right'  => $attributes['style']['spacing']['margin']['right'] ?? '',
			'margin-bottom' => $attributes['style']['spacing']['margin']['bottom'] ?? '',
			'margin-left'   => $attributes['style']['spacing']['margin']['left'] ?? '',
		];

		$figure->setAttribute( 'style', css_array_to_string( $css ) . ';' . $figure->getAttribute( 'style' ) );
	}

	return $dom->saveHTML();
}
