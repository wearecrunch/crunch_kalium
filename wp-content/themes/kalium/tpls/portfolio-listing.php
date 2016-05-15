<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $i, $pagename, $dynamic_image_height;

# Retrieve portfolio query
include_once THEMEDIR . 'tpls/portfolio-query.php';

# Portfolio Container Class
$portfolio_container_class = array();
$portfolio_container_class[] = 'portfolio-holder';
$portfolio_container_class[] = 'portfolio-' . $portfolio_type;

if ( isset( $portfolio_type_2_grid_spacing ) && $portfolio_type_2_grid_spacing == 'merged' ) {
	$portfolio_container_class[] = 'default-horizontal-margin';
}

if ( ( $portfolio_type == 'type-2' && $masonry_style_portfolio ) || ( $portfolio_type == 'type-2' && $dynamic_image_height ) || $portfolio_type_1_dynamic_height ) {
	$portfolio_container_class[] = 'is-masonry-layout';
}

if ( apply_filters( 'portfolio_container_isotope_category_sort_by_js', false ) ) {
	$portfolio_container_class[] = 'sort-by-js';
}

// When set as homepage
if ( is_front_page() ) {
	$pagename = get_post( get_option( 'page_on_front' ) )->post_name;
}

// Item Spacing
if ( $portfolio_type == 'type-2' && $portfolio_type_2_grid_spacing == 'normal' && ! empty( $portfolio_type_2_default_spacing ) && is_numeric( $portfolio_type_2_default_spacing ) ) {
	$portfolio_container_class[] = 'portfolio-loop-custom-item-spacing';
	
	generate_custom_style( '.page-container > .row', "margin: 0 " . ( -$portfolio_type_2_default_spacing / 2 ) . "px;" );
	generate_custom_style( '.portfolio-holder.portfolio-loop-custom-item-spacing [data-portfolio-item-id]', 'padding: ' . ( $portfolio_type_2_default_spacing / 2 ) . 'px;' );
}

// Pagination Type Class
$portfolio_container_class[] = 'pagination-type-' . esc_attr( $pagination_type );

if ( $max_num_pages <= 1 ) {
	$portfolio_container_class[] = 'all-items-in';
}

// If its browsing specific portfolio category
if ( is_tax( 'portfolio_category' ) ) {
	$portfolio_container_class[] = 'browsing-single-category';
}

?>
<div class="container">

	<?php include locate_template( 'tpls/portfolio-listing-title.php' ); ?>

	<div class="page-container">
		<div class="row">
			
			<?php do_action( 'kalium_portfolio_items_before', $portfolio_query ); ?>
			
			<div id="portfolio-items-container" class="<?php echo implode( ' ', $portfolio_container_class ); ?>">
			<?php
			$i = 0;
			
			while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

				switch( $portfolio_type ) :
				
					case 'type-1':
						get_template_part( 'tpls/portfolio-loop-item-type-1' );
						break;

					case 'type-2':
						get_template_part( 'tpls/portfolio-loop-item-type-2' );
						break;
						
				endswitch;
				
				$i++;

			endwhile;
			?>
			</div>
			
			<?php do_action( 'kalium_portfolio_items_after' ); ?>

			<?php
			// When browsing single category, declare custom query as well
			$browsing_category_endless = is_tax( 'portfolio_category' ) && in_array( $pagination_type, array( 'endless', 'endless-reveal' ) );
			
			if ( $max_num_pages > 1 || $browsing_category_endless ) :

				switch ( $pagination_type ) {
					case 'endless':
					case 'endless-reveal':
						
						$endless_opts = array(
							'per_page'	   => $portfolio_query->query_vars['posts_per_page'],
							'current'      => $current_page + 1,
							'maxpages'     => $browsing_category_endless ? ( $current_page + 1 ) : $max_num_pages,

							'reveal'       => $pagination_type == 'endless-reveal',

							'action'       => 'laborator_get_paged_portfolio_items',
							'callback'     => 'laboratorGetPortfolioItems',

							'type'  	   => get_data( 'portfolio_endless_pagination_style' ),

							'finished'	   => __( 'No more portfolio items to show', 'kalium' ),

							'opts'         => array(
								'pagename' => $pagename,
								'q' 	   => lab_rot13_tourl_encrypt( $portfolio_query->query ),
							),
							
							'visible'	   => ! $browsing_category_endless
						);

						laborator_show_endless_pagination( $endless_opts );
						break;

					default:
						laborator_show_pagination( $current_page, $max_num_pages, $from, $to, $pagination_position );
				}
			
			endif;
			
			?>
		</div>
	</div>

</div>
