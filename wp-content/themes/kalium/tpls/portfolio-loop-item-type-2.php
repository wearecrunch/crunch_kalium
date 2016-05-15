<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

// Get Portfolio Item Details
include locate_template( 'tpls/portfolio-item-details.php' );

$portfolio_image_size = 'portfolio-img-2';

// Item Classes
$item_class[] = 'sm-half-padding-tb';

if ( $portfolio_type_2_grid_spacing == 'normal' ) {
	$item_class[] = 'with-padding';
}


// Hover effect style
$custom_hover_effect_style = '';

if ( ! in_array( $hover_effect_style, array( 'inherit', '' ) ) ) {
	$custom_hover_effect_style = $hover_effect_style;
}


// No transparency (custom value)
if ( in_array( $custom_hover_color_transparency, array( 'opacity', 'no-opacity' ) ) ) {
	$portfolio_type_2_hover_transparency = $custom_hover_color_transparency;
}

if ( $custom_hover_background_color ) {
	generate_custom_style( ".post-{$portfolio_item_id} .product-box .thumb .hover-state", "background-color: {$custom_hover_background_color} !important;" );
}


// Set Column Width for Masonry Mode
$box_size = '';

if ( isset( $masonry_items_list ) && is_array( $masonry_items_list ) && count( $masonry_items_list ) ) {
	foreach ( $masonry_items_list as $item ) {
		if ( isset( $item['item'] ) && $item['item'] instanceof WP_Post && $item['item']->ID == $portfolio_item_id ) {
			$box_size = $item['box_size'];
			break;
		}
	}
}
else if ( isset( $lab_vc_portfolio_items_details ) && count( $lab_vc_portfolio_items_details ) ) {
	foreach ( $lab_vc_portfolio_items_details as $item ) {
		if ( $item['portfolio_id'] == $portfolio_item_id ) {
			$box_size = ! empty( $item['box_size'] ) ? $item['box_size'] : '8x3';
		}
	}
}


// Custom Box Size
if ( $box_size ) {
	$image_quality = 1.15;
	
	$grid_width   = apply_filters( 'kalium_portfolio_image_max_box_size', 1170 );
	$grid_spacing = 30;
	
	if ( $portfolio_type_2_default_spacing ) {
		$grid_spacing = $portfolio_type_2_default_spacing;
	}

	if ( isset( $portfolio_type_2_grid_spacing ) && $portfolio_type_2_grid_spacing == 'merged' ) {
		$grid_spacing = 0;
	}

	$grid_width   += $grid_spacing;

	$box_h1 = $grid_width / 12;

	$box_h3 = ceil( $box_h1 * 3 );
	$box_h4 = ceil( $box_h1 * 4 );
	$box_h5 = ceil( $box_h1 * 5 );
	$box_h6 = ceil( $box_h1 * 6 );

	// X-axis
	$column_width = $grid_width / 12;
	
	$box_w12   = $column_width * 12;
	$box_w9    = $column_width * 9;
	$box_w8    = $column_width * 8;
	$box_w6    = $column_width * 6;
	$box_w5    = $column_width * 5;
	$box_w4    = $column_width * 4;
	$box_w3    = $column_width * 3;

	// Y-axis
	$box_h3   -= $grid_spacing;
	$box_h4   -= $grid_spacing;
	$box_h5   -= $grid_spacing;
	$box_h6   -= $grid_spacing;

	switch ( $box_size ) {
		case "12x4": $portfolio_image_size = array( $box_w12, $box_h4 ); $item_class[] = 'w12'; break;
		case "12x5": $portfolio_image_size = array( $box_w12, $box_h5 ); $item_class[] = 'w12'; break;
		case "12x6": $portfolio_image_size = array( $box_w12, $box_h6 ); $item_class[] = 'w12'; break;

		case "9x3": $portfolio_image_size = array( $box_w9, $box_h3 ); $item_class[] = 'w9'; break;
		case "9x4": $portfolio_image_size = array( $box_w9, $box_h4 ); $item_class[] = 'w9'; break;
		case "9x6": $portfolio_image_size = array( $box_w9, $box_h6 ); $item_class[] = 'w9'; break;

		case "8x3": $portfolio_image_size = array( $box_w8, $box_h3 ); $item_class[] = 'w8'; break;
		case "8x4": $portfolio_image_size = array( $box_w8, $box_h4 ); $item_class[] = 'w8'; break;
		case "8x6": $portfolio_image_size = array( $box_w8, $box_h6 ); $item_class[] = 'w8'; break;

		case "6x3": $portfolio_image_size = array( $box_w6, $box_h3 ); $item_class[] = 'w6'; break;
		case "6x4": $portfolio_image_size = array( $box_w6, $box_h4 ); $item_class[] = 'w6'; break;
		case "6x6": $portfolio_image_size = array( $box_w6, $box_h6 ); $item_class[] = 'w6'; break;

		case "5x3": $portfolio_image_size = array( $box_w5, $box_h3 ); $item_class[] = 'w5'; break;
		case "5x4": $portfolio_image_size = array( $box_w5, $box_h4 ); $item_class[] = 'w5'; break;
		case "5x6": $portfolio_image_size = array( $box_w5, $box_h6 ); $item_class[] = 'w5'; break;

		case "4x3": $portfolio_image_size = array( $box_w4, $box_h3 ); $item_class[] = 'w4'; break;
		case "4x4": $portfolio_image_size = array( $box_w4, $box_h4 ); $item_class[] = 'w4'; break;
		case "4x6": $portfolio_image_size = array( $box_w4, $box_h6 ); $item_class[] = 'w4'; break;

		case "3x3": $portfolio_image_size = array( $box_w3, $box_h3 ); $item_class[] = 'w3'; break;
		case "3x4": $portfolio_image_size = array( $box_w3, $box_h4 ); $item_class[] = 'w3'; break;
		case "3x6": $portfolio_image_size = array( $box_w3, $box_h6 ); $item_class[] = 'w3'; break;
	}
	
	
	if ( $portfolio_image_size ) {
		$portfolio_image_size[0] -= $grid_spacing;
		
		$portfolio_image_size[0] *= $image_quality;
		$portfolio_image_size[1] *= $image_quality;
		
		$portfolio_image_size[0] = floor( $portfolio_image_size[0] );
		$portfolio_image_size[1] = floor( $portfolio_image_size[1] );
	}
	
	// Masonry with proportional thumbs
	if ( apply_filters( 'kalium_portfolio_masonry_proportional_thumbs', false ) ) {
		$portfolio_image_size = array( $portfolio_image_size[0], 0 );
	}
}
// Default Column Size
else {
	switch ( $columns_count ) {
		case 'six':
			$item_class[] = 'w6';
			break;

		case 'four':
			$item_class[] = 'w4';
			break;

		case 'three':
			$item_class[] = 'w3';
			break;
	}

	if ( $dynamic_image_height && ! preg_match( "/^[a-z_-]+$/i", $portfolio_image_size ) ) {
		$portfolio_image_size = 'portfolio-img-3';
	}
}


// Hover State Class
$hover_state_class = array();
$hover_state_class[] = 'hover-state';
$hover_state_class[] = 'padding';
$hover_state_class[] = 'position-' . $portfolio_type_2_hover_text_position;
$hover_state_class[] = 'hover-' . ( $custom_hover_effect_style ? $custom_hover_effect_style : $portfolio_type_2_hover_effect );
$hover_state_class[] = 'hover-style-' . $portfolio_type_2_hover_style;
$hover_state_class[] = 'opacity-' . ($portfolio_type_2_hover_transparency == 'opacity' ? 'yes' : 'no');
$hover_state_class[] = 'hover-eff-fade-slide';


if ( in_array( $hover_layer_options, array( 'always-hover', 'hover-reverse' ) ) ) {
	$hover_state_class[] = 'hover-is-visible';

	if ( $hover_layer_options == 'hover-reverse' ) {
		$hover_state_class[] = 'hover-reverse';
	}
}

// If there is no thumbnail, skip the item
if ( ! $post_thumbnail_id ) {
	return;
}

// Disable linking
if ( $item_linking == 'external' && '#' == $item_launch_link_href ) {
	$portfolio_item_href = '#';
	$item_class[] = 'not-clickable';
}
?>
<div <?php post_class( $item_class ); ?> data-portfolio-item-id="<?php echo $portfolio_item_id; ?>"<?php if ( $portfolio_terms_slugs ): ?> data-terms="<?php echo implode( ' ', $portfolio_terms_slugs ); ?>"<?php endif; ?>>

	<?php do_action( 'kalium_portfolio_item_before', $portfolio_item_type ); ?>

	<div class="product-box <?php echo esc_attr( $show_effect ); ?>"<?php if ( $reveal_delay ): ?> data-wow-delay="<?php echo esc_attr( $reveal_delay ); ?>s"<?php endif; ?>>
    	<div class="thumb">
	    	<?php if ( $portfolio_type_2_hover_effect != 'none' ): ?>
    		<div class="<?php echo implode( ' ', $hover_state_class ); ?>">

	    		<?php if ( get_data( 'portfolio_likes' ) && $portfolio_type_2_likes_show ): $likes = get_post_likes(); ?>
	    		<div class="likes">
		    		<a href="#" class="like-btn" data-id="<?php echo get_the_id(); ?>">
						<i class="icon fa <?php echo $likes['liked'] ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
						<span class="counter like-count"><?php echo esc_html( $likes['count'] ); ?></span>
					</a>
		    	</div>
	    		<?php endif; ?>

	    		<div class="info">
		    		<h3>
			    		<a href="<?php echo esc_url( $portfolio_item_href ); ?>" <?php if ( $portfolio_item_new_window ): ?> target="_blank"<?php endif; ?>><?php echo esc_html( $portfolio_item_title ); ?></a>
			    	</h3>
		    		<?php get_template_part( 'tpls/portfolio-loop-item-categories' ); ?>
		    	</div>
		    </div>
		    <?php endif; ?>

			<a href="<?php echo esc_url( $portfolio_item_href ); ?>" <?php if ( $portfolio_item_new_window ): ?> target="_blank"<?php endif; ?>>
				<?php laborator_show_image_placeholder( $post_thumbnail_id, apply_filters( 'kalium_portfolio_loop_thumbnail_2', $portfolio_image_size ), 'do-lazy-load-on-shown' ); ?>
			</a>
		</div>
	</div>
	
	<?php do_action( 'kalium_portfolio_item_after' ); ?>

</div>
