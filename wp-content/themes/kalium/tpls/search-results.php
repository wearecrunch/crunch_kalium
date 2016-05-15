<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $wpdb, $wp_query, $s, $page;

$found_posts = $wp_query->found_posts;

# Pagination
$pagination_position	= 'center';
$max_num_pages		  = $wp_query->max_num_pages;
$paged				  = get_query_var( 'paged' );

if ( is_numeric( $page ) && $page > $paged ) {
	$paged = $page;
}

if ( $max_num_pages > 1 ) :
	$_from                 = 1;
	$_to                   = $max_num_pages;
	$current_page          = $paged ? $paged : 1;
	$numbers_to_show       = 5;
	$pagination_position   = strtolower( $pagination_position );

	list( $from, $to )     = generate_from_to( $_from, $_to, $current_page, $max_num_pages, $numbers_to_show );
endif;
?>
<div class="container">

	<div class="section-title">
		<?php
		$search_link = '<a href="#" class="change-search-keyword" title="' . __('Click to change your search', 'kalium') . '" data-search-url="' . esc_attr( home_url( "?s=" ) ) . '">' . esc_html( $s ) . '</a>';
		?>
		<h1><?php printf( __( '%d results for “%s”', 'kalium' ), $found_posts, $search_link ); ?></h1>
		<p><?php echo $found_posts == 0 ? __( 'There is nothing found that matches your search criteria.', 'kalium' ) : sprintf( _n( 'We have found one match with the word you searched.', 'We have found %d results with the word you searched.', $found_posts, 'kalium' ), $found_posts ); ?></p>
	</div>

	<div class="page-container">
		<div class="search-results-holder">

			<?php
			if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					?>
					<div class="result-box">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo the_excerpt(); ?></p>
						<a href="<?php the_permalink(); ?>"><?php _e( 'Continue &#65515;', 'kalium' ); ?></a>
					</div>
					<?php

				endwhile;

				if ( $max_num_pages > 1 ) :

					laborator_show_pagination( $current_page, $max_num_pages, $from, $to, $pagination_position );

				endif;

			endif;
			?>
		</div>
	</div>

</div>