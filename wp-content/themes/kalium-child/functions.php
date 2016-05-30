<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

// This will enqueue style.css of child theme
add_action( 'wp_enqueue_scripts', 'enqueue_childtheme_scripts', 100 );
function enqueue_childtheme_scripts() {
	wp_enqueue_style( 'kalium-child', get_stylesheet_directory_uri() . '/style.css' );
}


/**
* WPML - custom language choice
*/
function icl_post_languages(){
	if( function_exists( 'icl_get_languages' ) ) {
		$languages = icl_get_languages( 'skip_missing=0&orderby=code&order=DESC' );
		if(!empty( $languages )){
			foreach( $languages as $key => $l ){
				if( $l['country_flag_url'] ){
					if( !$l['active'] ) { echo '<a href="'.$l['url'].'">'; }
						echo '<span>'. esc_attr( $l['language_code'] ) .'</span>';
					if( !$l['active'] ) { echo '</a>'; }
					if( $key == 'da' ) { echo ' | '; }
				}
			}
		}
	}
}