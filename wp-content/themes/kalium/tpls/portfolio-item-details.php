<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


global
	$i,
	
	$portfolio_url,
	$columns_count,
	$show_effect,
	$reveal_effect,
	$is_page_type,
	$portfolio_item_terms,
	$post_thumbnail_id,

	$portfolio_type_1_dynamic_height,
	$portfolio_type_1_hover_effect,
	$portfolio_type_1_hover_animatd_eye,

	$portfolio_type_2_grid_spacing,
	$portfolio_type_2_default_spacing,
	$portfolio_type_2_hover_effect,
	$portfolio_type_2_hover_text_position,
	$portfolio_type_2_hover_style,
	$portfolio_type_2_likes_show,

	$masonry_items_list,
	$dynamic_image_height,
	
	$lab_vc_portfolio_items_details,
	
	$portfolio_item_new_window;


// Item Class
$item_class = array( 'isotope-item' );


// Item Details
$portfolio_item_id      = get_the_ID();
$portfolio_item_title   = get_the_title();
$portfolio_item_href    = get_permalink();

$portfolio_item_type	= get_field( 'item_type' );

$portfolio_item_new_window = false;

$portfolio_item_terms = get_the_terms( $portfolio_item_id, 'portfolio_category' );
$portfolio_terms_slugs = array();

// Featured Image Id
$post_thumbnail_id = get_post_thumbnail_id();

	// Custom Vars
	$portfolio_type_1_hover_transparency    = get_data( 'portfolio_type_1_hover_transparency' );
	$portfolio_type_2_hover_transparency    = get_data( 'portfolio_type_2_hover_transparency' );

	$custom_hover_background_color          = get_field( 'custom_hover_background_color' );
	$custom_hover_color_transparency        = get_field( 'hover_color_transparency' );

	$hover_effect_style						= get_field( 'hover_effect_style' );
	$hover_layer_options                    = get_field( 'hover_layer_options' );

	$box_size                           	= get_field( 'portfolio_type_4_box_size' );


// Portfolio Item Type Class
$item_class[] = 'portfolio-item-' . $portfolio_item_type;


// Create Term Slugs
if ( is_array( $portfolio_item_terms ) ) {
	foreach ( $portfolio_item_terms as $term ) {
		$portfolio_terms_slugs[] = $term->slug;
	}
}


// Columns Count
$columns_count_num = 3;

switch ( $columns_count ) {
	case 'six':
		$columns_count_num = 2;
		break;

	case 'four':
		$columns_count_num = 3;
		break;

	case 'three':
		$columns_count_num = 4;
		break;
}


// Effect
$show_effect  = '';
$reveal_delay = 0.00;
$delay_wait   = 0.15;

if ( preg_match( '/-one/i', $reveal_effect ) ) {
	$reveal_delay = $i % ( $columns_count_num * 2 ) * $delay_wait; //$reveal_delay = $i * $delay_wait;
}

switch ( $reveal_effect ) {
	case 'fade':
	case 'fade-one':
		$show_effect = 'fadeIn';
		break;

	case 'slidenfade':
	case 'slidenfade-one':
		$show_effect = 'fadeInLab';
		break;

	case 'zoom':
	case 'zoom-one':
		$show_effect = 'zoomIn';
		break;
}

if ( $show_effect ) {
	$show_effect = "wow {$show_effect}";
}


// Custom Link
$item_linking           = get_field( 'item_linking' );
$item_launch_link_href  = get_field( 'launch_link_href' );
$item_new_window        = get_field( 'new_window' );

if ( $item_linking == 'external' && $item_launch_link_href && $item_launch_link_href != '#' ) {
	$portfolio_item_href = $item_launch_link_href;
	$portfolio_item_new_window = $item_new_window;
}