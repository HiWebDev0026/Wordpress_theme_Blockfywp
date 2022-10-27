<?php

declare( strict_types=1 );

namespace Blockify\Theme;

use function add_filter;
use function is_admin;
use function wp_add_inline_style;
use function wp_get_global_styles;
use function wp_list_pluck;

add_filter( 'wp_theme_json_data_theme', NS . 'add_all_fonts_in_editor' );
add_filter( 'theme_json_theme', NS . 'add_all_fonts_in_editor' );
/**
 * Add all fonts to the editor.
 *
 * @param mixed $theme_json Theme JSON.
 *
 * @return mixed
 */
function add_all_fonts_in_editor( $theme_json ) {
	$data  = $theme_json->get_data();
	$fonts = is_admin() ? get_all_fonts() : array_merge(
		get_selected_fonts( wp_get_global_styles() ),
		get_selected_fonts( $data['styles'] ?? [] ),
	);

	if ( $fonts ) {
		$data['settings']['typography']['fontFamilies']['theme'] = $fonts;

		$theme_json->update_with( $data );
	}

	return $theme_json;
}

add_filter( 'wp_enqueue_scripts', NS . 'add_system_font_stacks' );
add_filter( 'admin_enqueue_scripts', NS . 'add_system_font_stacks' );
/**
 * Adds system font stack custom properties.
 *
 * @since 1.0.0
 *
 * @return void
 */
function add_system_font_stacks(): void {
	$styles       = [];
	$system_fonts = get_system_fonts();

	foreach ( $system_fonts as $font ) {
		$styles[ '--wp--custom--font-stack--' . $font['slug'] ] = $font['fontFamily'];
	}

	$css = ':root{' . css_array_to_string( $styles ) . '}';

	wp_add_inline_style(
		is_admin() ? 'blockify-editor' : 'global-styles',
		$css
	);
}

/**
 * Returns array of user selected font families.
 *
 * @since 0.4.0
 *
 * @param array $styles Theme styles.
 *
 * @return array
 */
function get_selected_fonts( array $styles ): array {
	if ( ! $styles ) {
		return [];
	}

	$selected_fonts = [];
	$font_families  = [];
	$item_groups    = [
		[ $styles ],
		$styles['elements'] ?? [],
		$styles['blocks'] ?? [], // Not supported by core.
	];

	foreach ( $item_groups as $item_group ) {
		foreach ( $item_group as $item ) {
			$font_family = $item['typography']['fontFamily'] ?? '';

			if ( $font_family ) {
				$font_families[] = $font_family;
			}
		}
	}

	foreach ( $font_families as $font_family ) {
		if ( str_contains( $font_family, 'var(--' ) ) {
			$explode_font = explode( '--', str_replace( ')', '', $font_family ) );
		} else {
			$explode_font = explode( '|', $font_family );
		}

		$slug = end( $explode_font );
		$name = ucwords( str_replace( '-', ' ', $slug ) );

		if ( in_array( $slug, [ 'sans-serif', 'serif', 'monospace', 'inherit', 'initial' ], true ) ) {
			continue;
		}

		$selected_fonts[] = [
			'fontFamily' => $name,
			'name'       => $name,
			'slug'       => $slug,
			'fontFace'   => [
				[
					'fontFamily'  => $name,
					'fontStyle'   => 'normal',
					'fontStretch' => 'normal',
					'fontDisplay' => 'swap',
					'fontWeight'  => '100 900',
					'src'         => [
						"file:./assets/fonts/$slug.woff2",
					],
				],
			],
		];
	}

	return $selected_fonts;
}

/**
 * Returns an array of system fonts for custom properties.
 *
 * @since 0.4.0
 *
 * @return array
 */
function get_system_fonts(): array {
	return [
		[
			'name'       => 'Sans Serif',
			'slug'       => 'sans-serif',
			'fontFamily' => '-apple-system, BlinkMacSystemFont, avenir next, avenir, segoe ui, helvetica neue, helvetica, Cantarell, Ubuntu, roboto, noto, arial, sans-serif',
		],
		[
			'name'       => 'Serif',
			'slug'       => 'serif',
			'fontFamily' => 'Iowan Old Style, Apple Garamond, Baskerville, Times New Roman, Droid Serif, Times, Source Serif Pro, serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol',
		],
		[
			'name'       => 'Monospace',
			'slug'       => 'monospace',
			'fontFamily' => 'Menlo, Consolas, Monaco, Liberation Mono, Lucida Console, monospace',
		],
	];
}

/**
 * Returns an array of all available local fonts.
 *
 * @since 0.4.0
 *
 * @return array
 */
function get_all_fonts(): array {
	$font_families = get_system_fonts();
	$font_slugs    = wp_list_pluck( $font_families, 'slug' );
	$font_files    = [
		...glob( get_stylesheet_directory() . '/assets/fonts/*.woff2' ),
		...glob( get_template_directory() . '/assets/fonts/*.woff2' ),
	];

	foreach ( $font_files as $font_file ) {
		$slug = basename( $font_file, '.woff2' );

		if ( in_array( $slug, $font_slugs, true ) ) {
			continue;
		}

		$font_slugs[] = $slug;
		$name         = ucwords( str_replace( '-', ' ', $slug ) );

		$font_families[] = [
			'fontFamily' => $name,
			'name'       => $name,
			'slug'       => $slug,
			'fontFace'   => [
				[
					'fontFamily'  => $name,
					'fontStyle'   => 'normal',
					'fontStretch' => 'normal',
					'fontDisplay' => 'swap',
					'fontWeight'  => '100 900',
					'src'         => [
						"file:./assets/fonts/$slug.woff2",
					],
				],
			],
		];
	}

	return apply_filters( 'blockify_font_families', $font_families );
}
