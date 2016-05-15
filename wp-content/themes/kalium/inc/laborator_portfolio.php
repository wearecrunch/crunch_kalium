<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

// Location Rules for Portfolio Item Types
add_filter( 'acf/location/rule_types', 'laborator_acf_location_rules_types' );
add_filter( 'acf/location/match_field_groups', 'laborator_acf_location_rules_match_field_groups', 10, 3 );
add_filter( 'acf/location/rule_values/portfolio_item_type', 'laborator_acf_location_rules_values_item_type' );
add_filter( 'acf/location/rule_match/portfolio_item_type', 'laborator_acf_location_rules_item_type', 10, 3 );

function laborator_acf_location_rules_types( $choices ) {
	$choices['Other']['portfolio_item_type'] = 'Portfolio Item Type';

	return $choices;
}

function laborator_acf_location_rules_match_field_groups( $field_groups = array(), $options = array() ) {
	
	if ( ! defined( 'DOING_AJAX' ) ) {
		return $field_groups;
	}
	
	// Match Portfolio Item Type Group Fields
	if ( isset( $options['item_type'] ) ) {
		$post_id = $options['post_id'];
		
		// Update Current Portfolio Item Type
		$current_item_type = get_field( 'item_type', $post_id );
		update_field( 'item_type', $options['item_type'], $post_id );
		
		// Match New Rules
		$acf_location = new acf_location();
		$field_groups = $acf_location->match_field_groups( array(), $options );
		
		// Revert Back the Current Type
		if ( empty( $current_item_type ) ) {
			delete_field( 'item_type', $post_id );
		} else  {
			update_field( 'item_type', $current_item_type, $post_id );
		}
	}
	
	return $field_groups;
}

function laborator_acf_location_rules_values_item_type( $choices ) {
	$portfolio_item_types = array(
		'type-1' => 'Side Portfolio',
		'type-2' => 'Columned',
		'type-3' => 'Carousel',
		'type-4' => 'Zig Zag',
		'type-5' => 'Fullscreen',
		'type-6' => 'Lightbox',
		'type-7' => 'Visual Composer',
	);

	return $portfolio_item_types;
}

function laborator_acf_location_rules_item_type( $match, $rule, $options ) {
	$rule_item_type = $rule['value'];

	if ( $options['post_id'] ) {
		// Current Post
		$current_post = get_post( $options['post_id'] );
		$item_type = $current_post->item_type;

		if ( $rule['operator'] == "==" ) {
			return $rule_item_type == $item_type;
		}
	}
}


// Portfolio Like Column
add_filter( 'manage_edit-portfolio_columns', 'laborator_portfolio_like_column' );
add_action( 'manage_portfolio_posts_custom_column', 'laborator_portfolio_like_column_content', 10, 2 );

add_action( 'wp_ajax_lab_portfolio_reset_likes', 'lab_portfolio_reset_likes_ajax' );

function laborator_portfolio_like_column( $columns ) {
	$last_column = array_keys( $columns );
	$last_column = end( $last_column );
	
	$last_column_title = end( $columns );
	
	unset( $columns[ $last_column ] );
	
	$columns['likes'] = 'Likes';
	$columns[ $last_column ] = $last_column_title;
	
	return $columns;
}

function laborator_portfolio_like_column_content( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case "likes":
			$likes = get_post_likes();
			echo '<span class="likes-num">' . number_format_i18n( $likes['count'], 0 ) . '</span>';
			
			echo ' <a href="#" data-id="' . $post_id . '" class="portfolio-likes-reset" title="Reset likes for this item"> - <span>Reset</span></a>';
			break;
	}
}

function lab_portfolio_reset_likes_ajax() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	
	if ( isset( $_POST['post_id'] ) && is_numeric( $_POST['post_id'] ) ) {
		$post_id = $_POST['post_id'];
		$post = get_post( $post_id );
		
		if ( $post && $post->post_type == 'portfolio' ) {
			update_post_meta( $post_id, 'post_likes', array() );
			
			die( 'success' );
		}
	}
}

// Portfolio Type Column
add_filter( 'manage_edit-portfolio_columns', 'kalium_portfolio_item_type_column_filter' ) ;
add_action( 'manage_portfolio_posts_custom_column', 'kalium_portfolio_item_type_column_content_action', 10, 2 );
add_action( 'restrict_manage_posts', 'kalium_portfolio_item_type_filter_dropdown' );
add_filter( 'parse_query', 'kalium_portfolio_item_type_filter_query_request' );


function kalium_portfolio_item_type_column_filter( $columns ) {

	$columns['item_type'] = 'Item Type';
	
	if ( isset( $columns['comments'] ) ) {
		unset( $columns['comments'] );
	}
	
	if ( apply_filters( 'kalium_portfolio_remove_author_column', true ) ) {
		unset( $columns['author'] );
	}

	return $columns;
}

function kalium_portfolio_item_type_column_content_action( $column, $post_id ) {
	global $post;
	
	if ( $column == 'item_type' ) {
		
		$item_type = get_field( 'item_type' );
		$item_types = array(
			'type-1' => 'Side Portfolio',
			'type-2' => 'Columned',
			'type-3' => 'Carousel',
			'type-4' => 'Zig Zag',
			'type-5' => 'Fullscreen',
			'type-6' => 'Lightbox',
			'type-7' => 'Visual Composer',
		);
		
		if ( isset( $item_types[ $item_type ] ) ) :
		?>
		<a href="<?php echo add_query_arg( array( 'portfolio_item_type' => $item_type ) ); // get_edit_post_link( $post ); ?>" class="portfolio-item-type-column">
			<img src="<?php echo THEMEASSETS . 'images/admin/portfolio-item-' . $item_type . '.png'; ?>" />
			<?php echo $item_types[ $item_type ]; ?>
		</a>
		<?php
		endif;
	}
}

function kalium_portfolio_item_type_filter_dropdown() {
	global $pagenow, $typenow;
	
	if ( $pagenow == 'edit.php' && $typenow == 'portfolio' ) {
		
		$current_item_type = lab_get( 'portfolio_item_type' );
		
		$item_types = array(
			'type-1' => 'Side Portfolio',
			'type-2' => 'Columned',
			'type-3' => 'Carousel',
			'type-4' => 'Zig Zag',
			'type-5' => 'Fullscreen',
			'type-6' => 'Lightbox',
			'type-7' => 'Visual Composer',
		);
		?>
		<select name="portfolio_item_type" class="postform">
			<option value="">All item types</option>
			<?php
			foreach( $item_types as $item_type => $name ) :
				?>
				<option <?php echo selected( $current_item_type, $item_type ); ?> value="<?php echo $item_type; ?>"><?php echo $name; ?></option>
				<?php
			endforeach;
			?>
		</select>
		<?php
	}
}

function kalium_portfolio_item_type_filter_query_request( $query ) {
	global $pagenow, $typenow;
	
	$item_type = lab_get( 'portfolio_item_type' );
	
	if ( $pagenow == 'edit.php' && $typenow == 'portfolio' && ! empty( $item_type ) ) {
		$query->query_vars[ 'meta_key' ] = 'item_type';
		$query->query_vars[ 'meta_value' ] = $item_type;
	}
	
	return $query;
}


// Portfolio Pagination (endless)
add_action( 'wp_ajax_laborator_get_paged_portfolio_items', 'laborator_get_paged_portfolio_items', 1000 );
add_action( 'wp_ajax_nopriv_laborator_get_paged_portfolio_items', 'laborator_get_paged_portfolio_items', 1000 );

function laborator_get_paged_portfolio_items() {
	global $dynamic_image_height, $i;
	
	$resp = array(
		'content' => ''
	);

	// Query Meta Vars
	$page      = post( 'page' ); // Pagination – paged
	$pp        = post( 'pp' ); // Posts per page
	$opts      = post( 'opts' );
	$ignore    = post( 'ignore' ); // Ignore post ids
	$term	   = post( 'term' ); // Current term
	
	$q         = isset( $opts['q'] ) ? $opts['q'] : '';

	// Unserialize Query Details
	if ( $q ) {
		$q = lab_rot13_tourl_decrypt( $q );
	}

	$query_args = array(
		'post_type'           => 'portfolio',
		'posts_per_page'      => intval( $pp ),
		'paged'               => intval( $page ),
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);
	
	$post_limits_fn = create_function( '$limit, $query', 'return "LIMIT ' . $query_args['posts_per_page'] . '";' );
	
	// When post types order plugin is active, apply these query vars
	if ( defined( 'CPTPATH' ) ) {
		$query_args['orderby']    = 'menu_order';
		$query_args['order']      = 'ASC';
	}

	// Contatenate query arguments
	if ( $q ) {
		$query_args = array_merge( $q, $query_args );
	}
	
	// When Browsing All Items (Remove the category from query)
	if ( $pp == -1 && ! empty( $query_args['portfolio_category'] ) ) {
		unset( $query_args['portfolio_category'] );
	}
	
	// Ignore Ids
	if ( is_array( $ignore ) && count( $ignore ) > 0 ) {
		$query_args['post__not_in'] = $ignore;
		
		if ( $query_args['posts_per_page'] > 0 ) {
			add_filter( 'post_limits', $post_limits_fn, 10, 2 );
		}
	}
	
	// When browsing "All" term
	if ( $term == '*' ) {
		unset( $query_args['portfolio_category'] );
	}
	
	
	// Init query
	$query = new WP_Query( $query_args );
	
	
	// Remove LIMIT filter
	if ( $query_args['posts_per_page'] > 0 ) {
		remove_filter( 'post_limits', $post_limits_fn, 10, 2 );
	}
	
	// Import Portfolio Options
	if ( ! empty( $opts['pagename'] ) ) {
		global $post;

		query_posts( "pagename={$opts['pagename']}" ); // set as page in order to retrieve options
		$post = get_page_by_path( $opts['pagename'] );
	}
	
	include_once( THEMEDIR . 'tpls/portfolio-query.php' );

	// Collect posts
	ob_start();
	
	$i = 0;
	
	while( $query->have_posts() ) {

		$query->the_post();

		switch ( $portfolio_type ) {
			case 'type-1':
				get_template_part( 'tpls/portfolio-loop-item-type-1' );
				break;

			case 'type-2':
				get_template_part( 'tpls/portfolio-loop-item-type-2' );
				break;
		}
		
		$i++;
	}

	$content = ob_get_clean();

	// Set up content
	$resp['content'] = $content;
	$resp['req'] = $query_args;

	echo json_encode( $resp );

	die();
}


// Portfolio Listing Lightbox Entries
global $lb_entry_index;
$lb_entry_index = 0;

add_action( 'kalium_portfolio_items_before', 'kalium_portfolio_items_lightbox_entries', 10 );
add_action( 'kalium_portfolio_item_before', 'kalium_portfolio_item_lightbox_entry', 10, 2 );

function kalium_portfolio_items_lightbox_entries() {
	wp_enqueue_script( 'light-gallery' );
	wp_enqueue_style( array( 'light-gallery', 'light-gallery-transitions' ) );
	
	$portfolio_lb_speed = get_data( 'portfolio_lb_speed' );
	$portfolio_lb_hide_bars_delay = get_data( 'portfolio_lb_hide_bars_delay' );
	
	$portfolio_lb_thumbnails_container_height = get_data( 'portfolio_lb_thumbnails_container_height' );
	$portfolio_lb_thumbnails_width = get_data( 'portfolio_lb_thumbnails_width' );
	
	$portfolio_lb_autoplay_pause = get_data( 'portfolio_lb_autoplay_pause' );
	$portfolio_lb_zoom = get_data( 'portfolio_lb_zoom', '1' );
	
	$portfolio_lb_zoom_scale = get_data( 'portfolio_lb_zoom_scale' );
	
	$lg_options = array(
		
		'galleryId'				  => 'portfolio-slider',
		
		// Mode
		'mode'                    => get_data( 'portfolio_lb_mode', 'lg-fade' ),
		
		// Transitions Params
		'speed'                   => $portfolio_lb_speed ? floatval( $portfolio_lb_speed * 1000 ) : 600,
		'hideBarsDelay'           => $portfolio_lb_hide_bars_delay ? floatval( $portfolio_lb_hide_bars_delay * 1000 ) : 3000,
		
		// General Settings
		'hash'             		  => false,
		'loop'                    => wp_validate_boolean( get_data( 'portfolio_lb_loop', '1' ) ),
		'kaliumHash'              => wp_validate_boolean( get_data( 'portfolio_lb_hash', '1' ) ),
		'download'                => wp_validate_boolean( get_data( 'portfolio_lb_download', '1' ) ),
		'counter'                 => wp_validate_boolean( get_data( 'portfolio_lb_counter', '1' ) ),
		'enableDrag'              => wp_validate_boolean( get_data( 'portfolio_lb_draggable', '1' ) ),
		
		// Pager
		'pager'                   => wp_validate_boolean( get_data( 'portfolio_lb_pager', '0' ) ),
		
		// Full Screen
		'fullScreen'              => wp_validate_boolean( get_data( 'portfolio_lb_fullscreen', '1' ) ),
		
		// Thumbnails
		'thumbnail'               => wp_validate_boolean( get_data( 'portfolio_lb_thumbnails', '1' ) ),
		'animateThumb'            => wp_validate_boolean( get_data( 'portfolio_lb_thumbnails_animated', '1' ) ),
		'pullCaptionUp'           => wp_validate_boolean( get_data( 'portfolio_lb_thumbnails_pullcaptions_up', '1' ) ),
		'showThumbByDefault'      => wp_validate_boolean( get_data( 'portfolio_lb_thumbnails_show', '0' ) ),
		
		'thumbContHeight'         => $portfolio_lb_thumbnails_container_height ? intval( $portfolio_lb_thumbnails_container_height ) : 100,
		'thumbWidth'              => $portfolio_lb_thumbnails_width ? intval( $portfolio_lb_thumbnails_width ) : 100,
		
		'currentPagerPosition'    => 'middle',//TMPget_data( 'portfolio_lb_thumbnails_pager_position', 'middle' ),
		
		// Auto Play
		'autoplay'                => wp_validate_boolean( get_data( 'portfolio_lb_autoplay', '1' ) ),
		'autoplayControls'        => wp_validate_boolean( get_data( 'portfolio_lb_autoplay_controls', '1' ) ),
		'fourceAutoplay'          => wp_validate_boolean( get_data( 'portfolio_lb_autoplay_force_autoplay', '1' ) ),
		'progressBar'             => wp_validate_boolean( get_data( 'portfolio_lb_autoplay_progressbar', '1' ) ),
		
		'pause'                   => $portfolio_lb_autoplay_pause ? floatval( $portfolio_lb_autoplay_pause * 1000 ) : 5000,
		
		// Zoom
		'zoom'                    => wp_validate_boolean( $portfolio_lb_zoom ),
		'scale'                   => $portfolio_lb_zoom_scale ? floatval( $portfolio_lb_zoom_scale ) : 1,
		
		'startClass'			  => 'lg-start-fade ' . get_data( 'portfolio_lb_skin', 'lg-skin-kalium-default' )
	);
	
	$lg_options = apply_filters( 'kalium_lg_options', $lg_options );
	
	// Transparent Header Bar
	$transparent_bar = ! $lg_options['download'] && ! $lg_options['counter'] && ! $lg_options['fullScreen'] && ! $lg_options['autoplay'] && ! $lg_options['zoom'];
	
	if ( $transparent_bar ) {
		$lg_options['startClass'] .= ' transparent-header-bar';
	}
?>
<script>
var lgEntries = [], 
	lgOptions = <?php echo json_encode( $lg_options ); ?>;
</script>
<?php
}


function kalium_portfolio_item_lightbox_entry( $portfolio_item_type ) {
	
	global $post;
	
	// Show this content only for 
	if ( $portfolio_item_type != 'type-6' ) {
		return false;
	}
	
	$lb_entries 	   = array();
	
	$content_to_show   = get_field( 'content_to_show' );
	
	$custom_image      = get_field( 'custom_image' );
	$gallery           = get_field( 'image_and_video_gallery' );
	
	$self_hosted_video = get_field( 'self_hosted_video' );
	$youtube_video_url = get_field( 'youtube_video_url' );
	$vimeo_video_url   = get_field( 'vimeo_video_url' );
	
	$video_poster	   = get_field( 'video_poster' );
	
	switch ( $content_to_show ) {
		case 'other-image':
			$lb_entries[] = kalium_portfolio_lightbox_prepare_item( 'other-image', $custom_image );
			break;
		
		case 'gallery':
			foreach ( $gallery as $i => $item ) {
				$lb_entry = null;
				
				if ( preg_match( "/image\/.*/i", $item['mime_type'] ) ) { // Image Type
					$lb_entry = kalium_portfolio_lightbox_prepare_item( 'gallery-item-image', $item );
				} elseif ( preg_match( "/video\/.*/i", $item['mime_type'] ) ) { // Video Type
					$lb_entry = kalium_portfolio_lightbox_prepare_item( 'gallery-item-video', $item );
				}
				
				if ( $lb_entry ) {
					$lb_entry['subIndex'] = $i;
					$lb_entries[] = $lb_entry;
				}
			}
			break;
		
		case 'self-hosted-video':
			if ( preg_match( "/video\/.*/i", $self_hosted_video['mime_type'] ) ) {
				$lb_entries[] = kalium_portfolio_lightbox_prepare_item( 'gallery-item-video', $self_hosted_video, array ( 'poster' => $video_poster ) );
			}
			break;
		
		case 'youtube':
			if ( preg_match( '/youtube\.com/', $youtube_video_url ) ) {
				$lb_entries[] = kalium_portfolio_lightbox_prepare_item( 'youtube-video', $youtube_video_url, array ( 'poster' => $video_poster ) );
			}
			break;
		
		case 'vimeo':
			if ( preg_match( '/vimeo\.com/', $vimeo_video_url ) ) {
				$lb_entries[] = kalium_portfolio_lightbox_prepare_item( 'vimeo-video', $vimeo_video_url, array ( 'poster' => $video_poster )  );
			}
			break;
			
		default:
			$lb_entries[] = kalium_portfolio_lightbox_prepare_item( 'featured-image', $post );
	}
	
	// Remove Empty Entries
	ob_start();
	$lb_entries = array_filter( $lb_entries );
	
	echo '<script type="text/javascript">';
	
	foreach ( $lb_entries as $i => $lb_entry ) :
		$lb_entries[ $i ]['hash'] = $lb_entry['hash'] = $lb_entry['slug'] . ( $lb_entry['subIndex'] > 0 ? "/{$lb_entry['subIndex']}" : '' );
?>
lgEntries.push( <?php echo json_encode( $lb_entry ); ?> );<?php
	endforeach;
	
	echo '</script>';
	
	$entries_appends = ob_get_clean();
	
	laborator_append_content_to_footer( $entries_appends );
	
}

// Prepare Gallery Item
function kalium_portfolio_lightbox_prepare_item( $item_type, $item, $args = array() ) {
	
	global $post, $lb_entry_index;
	
	// Lightbox Object
	$lb_entry = array(
	);
	
	// Get Information
	$post_thumbnail_id = get_post_thumbnail_id();
	
	$content_to_show   = get_field( 'content_to_show' );
	$custom_image      = get_field( 'custom_image' );
	
	
	// Caption
	$caption_title = '';
	$caption_text = '';
	
	
	// Image Sizes
	$image_size_large = apply_filters( 'kalium_lightbox_image_size_large', 'original' );
	$image_size_thumb = apply_filters( 'kalium_lightbox_image_size_thumbnail', 'thumbnail' );
	$image_size_downl = apply_filters( 'kalium_lightbox_image_size_download', 'original' );
	
	switch ( $item_type ) {
		
		// Show Custom Image
		case 'other-image' :
			$caption_title   = get_the_title();
			$caption_text    = get_the_content();
		
			$img_large = wp_get_attachment_image_src( $item, $image_size_large );
			$img_thumb = wp_get_attachment_image_src( $item, $image_size_thumb );
			
			$img_downl = wp_get_attachment_image_src( $item, $image_size_downl );
			
			$lb_entry['src']         = $img_large[0];
			$lb_entry['thumb']       = $img_thumb[0];
			$lb_entry['downloadUrl'] = $img_downl[0];
			
			break;
		
		
		// Gallery Image Item
		case 'gallery-item-image' :
			$caption_title   = $item['title'];
			$caption_text    = $item['caption'] ? $item['caption'] : $item['description'];
		
			$img_large = wp_get_attachment_image_src( $item['id'], $image_size_large );
			$img_thumb = wp_get_attachment_image_src( $item['id'], $image_size_thumb );
			
			$img_downl = wp_get_attachment_image_src( $item['id'], $image_size_downl );
			
			$lb_entry['src']         = $img_large[0];
			$lb_entry['thumb']       = $img_thumb[0];
			$lb_entry['downloadUrl'] = $img_downl[0];
			
			break;
		
		// Gallery Video Item
		case 'gallery-item-video' :
			$caption_title   = $item['title'];
			$caption_text    = $item['caption'] ? $item['caption'] : $item['description'];
			
			if ( ! empty( $args['poster'] ) ) {
				$img_large = wp_get_attachment_image_src( $args['poster'], $image_size_large );
				$img_thumb = wp_get_attachment_image_src( $args['poster'], $image_size_thumb );
				
				$lb_entry['poster'] = $img_large[0];
			} else {
				$img_thumb = wp_get_attachment_image_src( $post_thumbnail_id, $image_size_thumb );
			}
			
			$video_id = 'video-' . md5( $item['id'] . $item['url'] );
			
			if ( ! empty( $img_large[0] ) ) {
				$lb_entry['poster']  = $img_large[0];
			}
			
			$lb_entry['thumb']   = $img_thumb[0];
			$lb_entry['html']    = '#' . $video_id;
			
			ob_start();
			?>
			<div id="<?php echo $video_id; ?>" class="hidden">
				<video class="lg-video-object lg-html5" controls preload="none">
					<source src="<?php echo $item['url']; ?>" type="<?php echo $item['mime_type']; ?>">
					<?php _e( 'Your browser does not support HTML5 video.', 'kalium' ); ?>
				</video>
			</div>
			<?php
			$video_footer_append = ob_get_clean();
			laborator_append_content_to_footer( $video_footer_append );
			
			
			/*
			$type = explode( '.', $item['url'] );
			$type = strtolower( end( $type ) );
			
			$shortcode = '[video ' . $type . '="' . esc_attr( $item['url'] ) . '"][/video]';
			
			$lg_class_fn = create_function( '$classes', '$classes .= " lg-video-object lg-html5"; return $classes;' );
			add_filter( 'wp_video_shortcode_class', $lg_class_fn );
			
			?>
			<div id="<?php echo $video_id; ?>" class="hidden">
				<?php echo do_shortcode( $shortcode ); ?>
			</div>
			<?php
			remove_filter( 'wp_video_shortcode_class', $lg_class_fn );
			*/
			break;
		
		
		// YouTube & Vimeo Video
		case 'youtube-video' :
		case 'vimeo-video' :
			$caption_title   = get_the_title();
			$caption_text    = get_the_content();
			
			
			if ( ! empty( $args['poster'] ) ) {
				$img_large = wp_get_attachment_image_src( $args['poster'], $image_size_large );
				$img_thumb = wp_get_attachment_image_src( $args['poster'], $image_size_thumb );
				
				$lb_entry['poster'] = $img_large[0];
			} else {
				$img_thumb = wp_get_attachment_image_src( $post_thumbnail_id, $image_size_thumb );
			}
			
			$lb_entry['href']    = $item;
			$lb_entry['src']     = $lb_entry['href'];
			$lb_entry['thumb']   = $img_thumb[0];
			break;
			
		
		// Show Featured Image
		case 'featured-image' :
			$caption_title   = get_the_title();
			$caption_text    = get_the_content();
		
			$img_large = wp_get_attachment_image_src( $post_thumbnail_id, $image_size_large );
			$img_thumb = wp_get_attachment_image_src( $post_thumbnail_id, $image_size_thumb );
			
			$img_downl = wp_get_attachment_image_src( $post_thumbnail_id, $image_size_downl );
			
			$lb_entry['src']         = $img_large[0];
			$lb_entry['thumb']       = $img_thumb[0];
			$lb_entry['downloadUrl'] = $img_downl[0];
	}
	
	if ( get_data( 'portfolio_lb_captions' ) ) :
		
		ob_start();
	
		$caption_id = lab_unique_id();
		$lb_entry['subHtml'] = '#lb-caption-' . $caption_id;
		?>
		<div id="lb-caption-<?php echo $caption_id; ?>" class="hidden">
			<?php if ( isset( $caption_title ) ) : ?>
			<h4><?php echo $caption_title; ?></h4>
			<?php endif; ?>
			
			<?php 
			if ( isset( $caption_text ) ) : 
				echo apply_filters( 'the_content', $caption_text );
			endif; 
			?>
		</div>
		<?php
			
		$caption_html = ob_get_clean();
		
		laborator_append_content_to_footer( $caption_html );
			
	endif;
	
	$lb_entry['index']             = $lb_entry_index;
	$lb_entry['subIndex']          = 0;
	$lb_entry['portfolioItemId']   = $post->ID;
	$lb_entry['slug']              = $post->post_name;
	
	$lb_entry_index++;
	
	return $lb_entry;
}


// Custom Image Size
$portfolio_lb_image_size_large = get_data( 'portfolio_lb_image_size_large' );
$portfolio_lb_image_size_thumbnail = get_data( 'portfolio_lb_image_size_thumbnail' );

if ( ! empty( $portfolio_lb_image_size_large ) ) {
	add_filter( 'kalium_lightbox_image_size_large' , create_function( '$size', 'return "' . esc_attr( $portfolio_lb_image_size_large ) . '";' ), 10 );
}

if ( ! empty( $portfolio_lb_image_size_thumbnail ) ) {
	add_filter( 'kalium_lightbox_image_size_thumbnail' , create_function( '$size', 'return "' . esc_attr( $portfolio_lb_image_size_thumbnail ) . '";' ), 10 );
}


// Remove Tags Column for Portfolio post type
if ( ! get_data( 'portfolio_enable_tags' ) ) {
	add_filter( 'portfolioposttype_tag_args', 'portfolioposttype_tag_args_remove_tags_column' );
}

function portfolioposttype_tag_args_remove_tags_column( $args ) {
	$args['show_admin_column'] = false;
	$args['show_ui'] = false;
	return $args;
}

// Lightbox Gallery Skin
add_filter( 'body_class', create_function( '$classes', '$classes[] = "body-' . str_replace( ' ', '-', get_data( 'portfolio_lb_skin' ) ) . '"; return $classes;' ) );


// Get Lightbox Navigation mode
function kalium_lb_get_navigation_mode() {
	if ( in_array( get_data( 'portfolio_lb_navigation_mode' ), array( '', 'single' ) ) ) {
		return 'single';
	}
	
	return 'linked';
}