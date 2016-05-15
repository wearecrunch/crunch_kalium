<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 11 );
function theme_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
}