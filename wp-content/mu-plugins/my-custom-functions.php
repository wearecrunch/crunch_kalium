<?php
/**
 * Plugin Name: My Custom Functions
 * Description: This is an awesome custom plugin with functionality that I'd like to keep when switching things.
 * Author: Vayu Robins
 * Author URI: http://flashkompagniet.dk
 * Version: 0.1.0
 */



// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/*
* Function to add or remove fields in user contacts
* Thanks: http://wpengineer.com/extend-user-contactinfo-wordpress-29/
*/
add_filter('user_contactmethods','my_new_contactmethods',10,1);
function my_new_contactmethods( $contactmethods ) {
	
	$contactmethods['company_name'] = 'Firmanavn';
	$contactmethods['address'] = 'Adresse';
	$contactmethods['zip'] = 'Post nr.';
	$contactmethods['city'] = 'By';
	$contactmethods['phone'] = 'Telefon';
	$contactmethods['cvr'] = 'CVR';
	
	// Remove
	unset($contactmethods['admin_color_classic']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['aim']);
	
	return $contactmethods;
}





// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/*
* Function to add an extra input textarea for encoded emails
*/
add_action( 'show_user_profile', 'show_extra_profile_fields' );
add_action( 'edit_user_profile', 'show_extra_profile_fields' );
function show_extra_profile_fields( $user ) { ?>

	<h3>Indkode din email</h3>

	<table class="form-table">

		<tr>
			<th><label for="encoded-email">Indkode din email</label></th>

			<td>
				<textarea name="encoded-email" id="encoded-email" cols="30" rows="5"><?php echo esc_attr( get_the_author_meta( 'encoded-email', $user->ID ) ); ?></textarea><br />
				<span class="description">Dette felt er til at sikkerheds indkode din email, som du kan gøre her på denne side: http://mailtoencoder.com/</span>
			</td>
		</tr>

	</table>
<?php }
add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );
function save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_user_meta( $user_id, 'encoded-email', esc_attr( $_POST['encoded-email'] ) );
}








// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/**
* Function to Display Post Thumbnail Also In Edit Post and Page Overview
* Thanks: http://wpengineer.com/display-post-thumbnail-post-page-overview/
*/
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
 
	// for post and page
	add_theme_support('post-thumbnails');
 
	function fb_AddThumbColumn($cols) {
 
		$cols['thumbnail'] = __('Thumbnail');
		return $cols;
	}
 
	function fb_AddThumbValue($column_name, $post_id) {
 
			$width = (int) 35;
			$height = (int) 35;
 
			if ( 'thumbnail' == $column_name ) {
				// thumbnail of WP 2.9
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				// image from gallery
				$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
				if ($thumbnail_id)
					$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				elseif ($attachments) {
					foreach ( $attachments as $attachment_id => $attachment ) {
						$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
					}
				}
					if ( isset($thumb) && $thumb ) {
						echo $thumb;
					} else {
						echo __('None');
					}
			}
	}
 
	// for posts
	add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
 
	// for pages
	add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
	
}









// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/**
* TinyMce editor modification, move buttons around
*/
add_filter("mce_buttons", "add_mce_buttons");
function add_mce_buttons($buttons){
	
	// Move the Format select up in place of the Read more button
	$buttons[16] = "formatselect";
	return $buttons;
}







// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/**
* Print_r function, that prints out a readable array
*/
function pre($array){
	echo '<pre>'.print_r($array,true).'</pre>';
}





// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
add_filter('body_class', 'add_pagename_class');
/**
* Adds new body class for post / page name
*/
function add_pagename_class($classes) {
	
	global $post;
	if( $post ){
		$classes[] = esc_attr( sanitize_html_class( $post->post_name ) );
	}
    return $classes;

}





// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
add_filter('jpeg_quality', 'jpeg_quality_callback');
/**
* Increase jpeg image quality for thumbs
*/
function jpeg_quality_callback($arg) {
	return (int)100;
}




// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
// remove junk from head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links', 2);
//remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);







// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/**
* Function that modifies permalink slug for æøå
* Inspired by http://www.wp-kontoret.dk/artikler/automatisk-rettelse-af-aeoeaa-i-permalinks/
* Created by Vayu Robins
*/
add_filter('sanitize_title', 'sanitize_title_dk', 0);
function sanitize_title_dk($seo_slug) {
	// We don't want to change an existing slug
	//if ($slug) return $slug;

	$patterns = array('/æ/','/ø/','/å/','/Æ/','/Ø/','/Å/','/ä/','/ö/','/Ä/','/Ö/','/&/');
	$replacements = array('ae','oe','aa','ae','oe','aa','ae','oe','ae','oe','&amp;');

	$seo_slug = preg_replace($patterns, $replacements, $seo_slug);

	return $seo_slug;

};








// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
/**
* Remove admin panels
*/
add_action('admin_menu','hide_meta_boxes');
function hide_meta_boxes() {
	// posts
	remove_meta_box( 'postcustom','post','normal' ); // Custom fields metabox
	remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt metabox
	remove_meta_box( 'trackbacksdiv','post','normal' ); // Trackbacks metabox
	
	// product
	remove_meta_box( 'postcustom','product','normal' ); // Custom fields metabox
	remove_meta_box( 'postexcerpt','product','normal' ); // Excerpt metabox
	remove_meta_box( 'trackbacksdiv','product','normal' ); // Trackbacks metabox

	// shop_order
	remove_meta_box( 'postcustom','shop_order','normal' ); // Custom fields metabox
	
	// portfolio
	remove_meta_box( 'postcustom','portfolio','normal' ); // Custom fields metabox
	
	// Pages
	remove_meta_box( 'postcustom','page','normal' ); // Custom fields metabox
	remove_meta_box( 'postexcerpt','page','normal' ); // Excerpt metabox
	remove_meta_box( 'trackbacksdiv','page','normal' ); // Trackbacks metabox
	remove_meta_box( 'commentstatusdiv','page','normal' );
	remove_meta_box( 'commentsdiv','page','normal' );
	remove_meta_box( 'pagecommentstatusdiv','page','normal' );	
	remove_meta_box( 'authordiv','page','normal' ); // Author metabox
}



// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
add_filter( 'default_hidden_meta_boxes', 'hidde_default_meta_boxes', 2 );
/**
* Change which meta boxes are hidden by default on the post and page edit screens.
*
* @since 2.7.0
*/
function hidde_default_meta_boxes( $hidden ) {

	global $current_screen;
	if( 'post' == $current_screen->id ) {
		$hidden = array( 'postexcerpt', 'trackbacksdiv', 'postcustom', 'commentstatusdiv', 'slugdiv', 'authordiv', 'genesis_inpost_scripts_box' );
		// Other hideable post boxes: genesis_inpost_scripts_box, commentsdiv, categorydiv, tagsdiv, postimagediv
	} elseif( 'page' == $current_screen->id ) {
		$hidden = array( 'postcustom', 'commentstatusdiv', 'slugdiv', 'authordiv', 'postimagediv','genesis_inpost_scripts_box' );
		// Other hideable post boxes: genesis_inpost_scripts_box, pageparentdiv
	}
	return $hidden;

}





// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
//add_filter( 'wp_mail_from', create_function( "", "return get_bloginfo('admin_email');" ) );
add_filter( 'wp_mail_from', function(){ return get_bloginfo('admin_email'); } );
//add_filter( 'wp_mail_from_name', create_function( "", "return get_bloginfo('name');" ) );
add_filter( 'wp_mail_from_name', function(){ return get_bloginfo( 'name' ); } );
/**
* WP notification email
*/





// ------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------
add_filter( 'sanitize_file_name', 'sanitize_special_chars_fileupload', 10 );
/**
* remove odd characters from filename on upload
*/
function sanitize_special_chars_fileupload ($filename) {
	return remove_accents( $filename );
}