<?php
/**
 *	Portfolio Items
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $dynamic_image_height;

$lab_vc_portfolio_items = true;

// Atts
$defaults = array(
	'portfolio_query'      => '',
	'portfolio_type'       => '',
	'columns'      		   => '',
	'portfolio_spacing'    => '',
	'dynamic_image_height' => '',
	'more_link'            => '',
	'category_filter'      => '',
	'title'                => '',
	'description'          => '',
	'el_class'             => '',
	'css'                  => ''
);

if( function_exists( 'vc_map_get_attributes' ) ) {
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
}

if ( empty( $atts['portfolio_query'] ) || ( ! empty( $atts['portfolio_query'] ) && strpos( $atts['portfolio_query'], "post_type:" ) == false ) ) {
	$atts['portfolio_query'] .= '|post_type:portfolio';
}

if ( isset( $lab_masonry_portfolio ) && $lab_masonry_portfolio == true ) {
	$atts['portfolio_type'] = 'type-2';
}

extract( $atts );

// Rebuild query params for Masonry Portfolio
if ( isset( $lab_masonry_portfolio ) && $lab_masonry_portfolio == true ) {
	$portfolio_query = 'size:-1|order_by:post__in|post_type:portfolio|by_id:0';
	
	foreach ( $lab_vc_portfolio_items_details as $item ) {
		$portfolio_query .= ",{$item['portfolio_id']}";
	}
	
	// Remove post type ordering
	if( function_exists( 'CPTOrderPosts' ) ) {
		remove_filter( 'posts_orderby', 'CPTOrderPosts', 99, 2 );
		$cpto_posts_orderby_removed = true;
	}
}


// Retrieve portfolio main details
include locate_template( 'tpls/portfolio-query.php' );


// Portfolio Masonry Query
list( $query_args, $tmp_query ) = vc_build_loop_query( $portfolio_query );

$query_args['meta_key'] = '_thumbnail_id';

$portfolio_query = new WP_Query( $query_args );


// Available Terms
$portfolio_query_available_terms = lab_get_available_terms_for_query( $query_args, 'portfolio_category' );


// Revert back post ordering filter
if( function_exists( 'CPTOrderPosts' ) && isset( $cpto_posts_orderby_removed ) && $cpto_posts_orderby_removed ) {
	add_filter( 'posts_orderby', 'CPTOrderPosts', 99, 2 );
	$cpto_posts_orderby_removed = false;
}

$more_link = vc_build_link( $more_link );


// Portfolio Vars
$columns_count = isset( $columns ) ? $columns : 'four';

if ( $portfolio_type == 'type-2' && $portfolio_spacing != 'inherit' ) {
	$portfolio_type_2_grid_spacing = $portfolio_spacing == 'yes' ? 'normal' : 'merged';
}

// Portfolio Container Class
$portfolio_container_class = array();
$portfolio_container_class[] = 'portfolio-holder';
$portfolio_container_class[] = 'portfolio-' . $portfolio_type;

if ( isset( $portfolio_type_2_grid_spacing ) && $portfolio_type_2_grid_spacing == 'merged' ) {
	$portfolio_container_class[] = 'default-horizontal-margin';
}

if ( ( $portfolio_type == 'type-2' && $dynamic_image_height ) || ( isset( $lab_masonry_portfolio ) && $lab_masonry_portfolio == true ) || $portfolio_type_1_dynamic_height ) {
	$portfolio_container_class[] = 'is-masonry-layout';
}

// Element Class
$class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$css_class = "lab-portfolio-items {$css_class}";



// Item Spacing
if ( $portfolio_type == 'type-2' && $portfolio_type_2_grid_spacing == 'normal' && ! empty( $portfolio_type_2_default_spacing ) && is_numeric( $portfolio_type_2_default_spacing ) ) {
	$portfolio_container_class[] = 'portfolio-loop-custom-item-spacing';
	
	generate_custom_style( '.portfolio-items-row', "margin: 0 " . ( -$portfolio_type_2_default_spacing / 2 ) . "px;" );
	generate_custom_style( '.portfolio-holder.portfolio-loop-custom-item-spacing [data-portfolio-item-id]', 'padding: ' . ( $portfolio_type_2_default_spacing / 2 ) . 'px;' );
}

?>
<div class="<?php echo esc_attr($css_class) . vc_shortcode_custom_css_class($css, ' '); ?>">
	
	<?php include locate_template('tpls/portfolio-listing-title.php'); ?>
	
	<div class="row portfolio-items-row">
		
		<?php do_action( 'kalium_portfolio_items_before', $portfolio_query ); ?>
		
		<div id="portfolio-items-container" class="<?php echo implode( ' ', $portfolio_container_class ); ?>">
			<?php
			$i = 0;
			
			while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
	
				global $i;
	
				switch ( $portfolio_type ) {
					case 'type-1':
						get_template_part( 'tpls/portfolio-loop-item-type-1' );
						break;
	
					case 'type-2':
						get_template_part( 'tpls/portfolio-loop-item-type-2' );
						break;
				}
				$i++;
	
			endwhile;
			
			wp_reset_postdata();
			?>
		</div>
		
		<?php do_action( 'kalium_portfolio_items_after' ); ?>
		
		<?php if ( $more_link['url'] && $more_link['title'] ) : ?>
		<div class="more-link <?php echo isset( $show_effect ) && $show_effect ? $show_effect : ''; ?>">
			<div class="show-more">
				<div class="button">
					<a href="<?php echo esc_url( $more_link['url'] ); ?>" target="<?php echo esc_attr( $more_link['target'] ); ?>" class="btn btn-white">
						<?php echo esc_html( $more_link['title'] ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	
</div>
<?php
$lab_vc_portfolio_items = false;
