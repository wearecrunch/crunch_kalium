<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$portfolio_category_filter = get_data( 'portfolio_category_filter' );
$portfolio_filter_enable_subcategories = get_data( 'portfolio_filter_enable_subcategories' );

if ( isset( $lab_vc_portfolio_items ) && $lab_vc_portfolio_items == true ) {
	$portfolio_title = $title;
	$portfolio_description = $description;
	
	$show_title_description = empty( $portfolio_title ) == false || empty( $portfolio_description ) == false;
	
	# Categories
	$current_portfolio_category    = '';
	$portfolio_category_filter     = $category_filter == 'yes';
} 

if ( ! $show_title_description && ! ( $portfolio_category_filter && $portfolio_query_available_terms ) ) {
	return;
}

// Category Slug
$category_slug = $portfolio_category_prefix_url_slug ? $portfolio_category_prefix_url_slug : 'portfolio-category';

if ( preg_match( "/\[vc_row.*?\]/", $portfolio_description ) && ! defined( 'HEADING_TITLE_DISPLAYED' ) ) {
	?>
	<div class="portfolio-title-vc-content">
		<?php echo do_shortcode( $portfolio_description ); ?>
	</div>
	<?php
		
	$portfolio_description = '';
}
?>
<div class="portfolio-title-holder">
	<?php if ( $show_title_description ) : ?>
	<div class="pt-column">
		<div class="section-title no-bottom-margin">
			<?php if ( $portfolio_title ) : ?>
			<h1><?php echo esc_html( $portfolio_title ); ?></h1>
			<?php endif; ?>
			<?php echo lab_esc_script( wpautop( $portfolio_description ) ); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( $portfolio_category_filter && count( $portfolio_query_available_terms ) > 0 ) : ?>
	<div class="pt-column">
		<div class="product-filter">
			<ul class="portfolio-root-categories">
				<li class="portfolio-category-all <?php when_match( $current_portfolio_category == '', 'active' ); ?>">
					<a href="<?php echo esc_url( $portfolio_url ); ?>" data-term="*"><?php _e( 'All', 'kalium' ); ?></a>
				</li>
			<?php
			
			foreach ( $portfolio_query_available_terms as $i => $term ) :
			
				if ( $term->parent != 0 ) {
					continue;
				}
				
				$is_active = $current_portfolio_category && $current_portfolio_category == $term->slug;
				$term_link = get_term_link( $term, 'portfolio_category' );
				
				if ( $is_page_type ) {
					$term_link = $portfolio_url . ( strpos( $_SERVER['REQUEST_URI'], '?' ) == false ? '?' : '&' ) . $category_slug . '=' . $term->slug;
				}
			?>
			<li class="portfolio-category-item portfolio-category-<?php echo $term->slug . ' '; when_match( $is_active, 'active' ); ?>">
				<a href="<?php echo esc_url( $term_link ); ?>" data-term="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
			</li>
			<?php
			endforeach;
			?>
			</ul>
			
			<?php
			if ( $portfolio_filter_enable_subcategories ) :
				
				foreach ( $portfolio_query_available_terms as $i => $term ) :
					lab_get_terms_by_parent_id( $term, array( 
						'available_terms'  => $portfolio_query_available_terms, 
						'portfolio_url'    => $portfolio_url, 
						'category_slug'    => $category_slug,
						'current_category' => $current_portfolio_category,
						'is_page_type'	   => $is_page_type
					) );
				endforeach;
				
			endif;
			?>
		</div>
	</div>
	<?php endif; ?>
</div>