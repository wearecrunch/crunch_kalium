<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $portfolio_type, $portfolio_item_terms, $is_page_type, $portfolio_url, $portfolio_category_prefix_url_slug;

// What to show
$portfolio_loop_subtitles = get_data( 'portfolio_loop_subtitles', 'categories' );
$sub_title = '';

// Hide option is selected
if ( $portfolio_loop_subtitles == 'hide' ) {
	return;
} elseif ( $portfolio_loop_subtitles == 'subtitle' ) {
	$sub_title = get_field( 'sub_title' );
}

// Category Prefix
$category_prefix = 'portfolio-category';

if ( $portfolio_category_prefix_url_slug ) {
	$category_prefix = $portfolio_category_prefix_url_slug;
}

// Show Subtitle
if ( $sub_title && $portfolio_loop_subtitles == 'subtitle' ) {
	echo '<p>' . do_shortcode( get_field( 'sub_title' ) ) . '</p>';
	
}
// Categories
elseif ( in_array( $portfolio_loop_subtitles, array( 'categories', 'categories-parent' ) ) && is_array( $portfolio_item_terms ) && count( $portfolio_item_terms ) > 0 ) {
	$j = 0;
	
	echo '<p>';
	
	foreach ( $portfolio_item_terms as $term ) :
	
		// Parent Categories Check
		if ( $portfolio_loop_subtitles == 'categories-parent' && $term->parent != 0 ) {
			continue;
		}
	
		$term_link = get_term_link( $term, 'portfolio_category' );
	
		if ( $is_page_type ) {
			$term_link = $portfolio_url . ( strpos( $_SERVER['REQUEST_URI'], '?' ) == false ? '?' : '&' ) . $category_prefix . '=' . $term->slug;
		}
	
		echo $j > 0 ? ', ' : '';
	
		?><a href="<?php echo esc_url( $term_link ); ?>" data-term="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a><?php
	
		$j++;
	
	endforeach;
	
	echo '</p>';
}