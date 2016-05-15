<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Get Portfolio Item Details
include locate_template( 'tpls/portfolio-item-details.php' );

	# Hover effect style
	$custom_hover_effect_style = '';
	
	if ( $hover_effect_style != 'inherit' ) {
		$custom_hover_effect_style = $hover_effect_style;
	}

	# No transparency (custom value)
	if ( in_array( $custom_hover_color_transparency, array( 'opacity', 'no-opacity' ) ) ) {
		$portfolio_type_1_hover_transparency = $custom_hover_color_transparency;
	}

	if ( $custom_hover_background_color ) {
		generate_custom_style( ".portfolio-holder .post-{$portfolio_item_id} .product-box .on-hover", "background-color: {$custom_hover_background_color} !important;" );
	}

$item_class[] = 'with-padding';
$item_class[] = 'sm-half-padding-lr';

switch ( $columns_count ) {
	case "six":
		$item_class[] = 'grid-two';
		break;

	case "four":
		$item_class[] = 'grid-three';
		break;

	case "three":
		$item_class[] = 'grid-four';
		break;
}

# Hover State Class
$hover_state_class = array();
$hover_state_class[] = 'on-hover';
$hover_state_class[] = 'opacity-' . ( $portfolio_type_1_hover_transparency == 'opacity' ? 'yes' : 'no' );

if ( $portfolio_type_1_hover_effect == 'distanced' || ( ! empty( $custom_hover_effect_style ) && $custom_hover_effect_style ) ) {
	$hover_state_class[] = 'distanced';
}

# If there is no thumbnail, skip the item
if ( ! $post_thumbnail_id ) {
	return;
}

$thumbnail_size = 'portfolio-img-1';

if ( $portfolio_type_1_dynamic_height ) {
	$thumbnail_size = preg_match( "/^[a-z_-]+$/i", $thumbnail_size ) ? $thumbnail_size : 'portfolio-img-3';
	$item_class[] = 'dynamic-height-image';
}

if ( $portfolio_type_1_hover_animatd_eye ) {
	$item_class[] = 'animated-eye-icon';
}
?>
<div <?php post_class( $item_class ); ?> data-portfolio-item-id="<?php echo $portfolio_item_id; ?>"<?php if ( $portfolio_terms_slugs ) : ?> data-terms="<?php echo implode( ' ', $portfolio_terms_slugs ); ?>"<?php endif; ?>>
	
	<?php do_action( 'kalium_portfolio_item_before', $portfolio_item_type ); ?>
	
	<div class="product-box <?php echo esc_attr( $show_effect ); ?>"<?php if ( $reveal_delay ) : ?> data-wow-delay="<?php echo esc_attr( $reveal_delay ); ?>s"<?php endif; ?>>
		<div class="photo do-lazy-load-on-shown">
			<a href="<?php echo esc_url( $portfolio_item_href ); ?>" <?php if ( $portfolio_item_new_window ) : ?> target="_blank"<?php endif; ?>>
				<?php laborator_show_image_placeholder( $post_thumbnail_id, apply_filters( 'kalium_portfolio_loop_thumbnail_1', $thumbnail_size ) ); ?>

				<?php if ( $portfolio_type_1_hover_effect != 'none' ) : ?>
				<span class="<?php echo implode( ' ', $hover_state_class ); ?>">
					<i class="icon icon-basic-eye"></i>
				</span>
				<?php endif; ?>
			</a>
		</div>

		<div class="info">
			<h3>
				<a href="<?php echo esc_url( $portfolio_item_href ); ?>">
					<?php echo esc_html( $portfolio_item_title ); ?>
				</a>
			</h3>

			<?php get_template_part( 'tpls/portfolio-loop-item-categories' ); ?>
		</div>
	</div>
	
	<?php do_action( 'kalium_portfolio_item_after' ); ?>
	
</div>