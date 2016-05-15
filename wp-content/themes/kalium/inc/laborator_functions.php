<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


// GET/POST getter
function lab_get( $var ) {
	return isset( $_GET[ $var ] ) ? $_GET[ $var ] : ( isset( $_REQUEST[ $var ] ) ? $_REQUEST[ $var ] : '' );
}

function post( $var ) {
	return isset( $_POST[$var] ) ? $_POST[ $var ] : ( isset( $_REQUEST[ $var ] ) ? $_REQUEST[ $var ] : null );
}

function cookie( $var ) {
	return isset( $_COOKIE[ $var ] ) ? $_COOKIE[ $var ] : null;
}

// Echo
function when_match( $bool, $str = '', $otherwise_str = '', $echo = true ) {
	$str = ' ' . trim( $bool ? $str : $otherwise_str );
	$str = esc_attr( $str );
	
	if ( $echo ) {
		echo $str;
		return '';
	}

	return $str;
}


// Generate From-To numbers borders
function generate_from_to( $from, $to, $current_page, $max_num_pages, $numbers_to_show = 5 ) {
	if ( $numbers_to_show > $max_num_pages ) {
		$numbers_to_show = $max_num_pages;
	}

	$add_sub_1 = round( $numbers_to_show / 2 );
	$add_sub_2 = round( $numbers_to_show - $add_sub_1 );

	$from = $current_page - $add_sub_1;
	$to = $current_page + $add_sub_2;

	$limits_exceeded_l = false;
	$limits_exceeded_r = false;

	if ( $from < 1 ) {
		$from = 1;
		$limits_exceeded_l = true;
	}

	if ( $to > $max_num_pages ) {
		$to = $max_num_pages;
		$limits_exceeded_r = true;
	}


	if ( $limits_exceeded_l ) {
		$from = 1;
		$to = $numbers_to_show;
	} elseif ( $limits_exceeded_r ) {
		$from = $max_num_pages - $numbers_to_show + 1;
		$to = $max_num_pages;
	} else {
		$from += 1;
	}

	if ( $from < 1 ) {
		$from = 1;
	}

	if ( $to > $max_num_pages ) {
		$to = $max_num_pages;
	}

	return array( $from, $to );
}

// Laborator Pagination
function laborator_show_pagination( $current_page, $max_num_pages, $from, $to, $pagination_position = 'full', $numbers_to_show = 5 ) {
	$current_page = $current_page ? $current_page : 1;

	?>
	<div class="clear"></div>

	<!-- pagination -->
	<div class="pagination-holder<?php echo " pagination-holder-" . esc_attr( $pagination_position ); ?>">

		<ul class="pagination">

		<?php /*TMP
	if ($current_page > 1): ?>
			<li class="first_page"><a href="<?php echo get_pagenum_link(1); ?>"><?php _e('&laquo; First's); ?></a></li>
		<?php endif;
	*/ ?>

		<?php if ( $current_page > 1 ) : ?>
			<li class="first_page">
				<a href="<?php echo get_pagenum_link( $current_page - 1 ); ?>">
					<i class="flaticon-arrow427"></i>
					<?php _e( 'Previous', 'kalium' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<?php

		if ( $from > floor( $numbers_to_show / 2 ) ) {
			?>
			<li>
				<a href="<?php echo get_pagenum_link( 1 ); ?>">1</a>
			</li>
			<li class="dots">
				<span>&hellip;</span>
			</li>
			<?php
		}

		for ( $i = $from; $i <= $to; $i++ ) :

			$link_to_page = get_pagenum_link( $i );
			$is_active = $current_page == $i;

		?>
			<li<?php echo $is_active ? ' class="active"' : ''; ?>>
				<a href="<?php echo esc_url( $link_to_page ); ?>"><?php echo esc_html( $i ); ?></a>
			</li>
		<?php
		endfor;


		if ( $max_num_pages > $to ) {
			if ( $max_num_pages != $i ) :
			?>
				<li class="dots">
					<span>&hellip;</span>
				</li>
			<?php
			endif;

			?>
			<li>
				<a href="<?php echo get_pagenum_link( $max_num_pages ); ?>"><?php echo esc_html( $max_num_pages ); ?></a>
			</li>
			<?php
		}
		?>

		<?php if ( $current_page + 1 <= $max_num_pages ) : ?>
			<li class="last_page">
				<a href="<?php echo get_pagenum_link( $current_page + 1 ); ?>">
					<?php _e( 'Next', 'kalium' ); ?> 
					<i class="flaticon-arrow413"></i>
				</a>
			</li>
		<?php endif; ?>

		<?php /*TMPif ($current_page < $max_num_pages): ?>
			<li class="last_page"><a href="<?php echo get_pagenum_link($max_num_pages); ?>"><?php _e('Last &raquo;', TD); ?></a></li>
		<?php endif;*/ ?>
		</ul>

	</div>
	<!-- end: pagination -->
	<?php

	// Deprecated (the above function displays pagination)
	/*
if (false):

		posts_nav_link();

	endif;
*/
}



// Get SMOF data
$data_cached            = array();
$smof_filters           = array();
$data                   = function_exists( 'of_get_options' ) ? of_get_options() : array();
$data_iteration_count   = 0;

function get_data( $var = '', $default = '' ) {
	global $data, $data_cached;

	if ( ! function_exists( 'of_get_options' ) ) {
		return null;
	}

	if ( isset( $data_cached[ $var ] ) ) {
		return apply_filters( "get_data_{$var}", $data_cached[ $var ] );
	}

	if ( isset( $data[ $var ] ) ) {		
		$data_cached[ $var ] = $data[ $var ];
		return apply_filters( "get_data_{$var}", $data[ $var ] );		
	} else if ( $default ) {
		$data[ $var ] = $default;
	}

	return $default;
}


// Compress Text Function
function compress_text( $buffer ) {
	/* remove comments */
	$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", '	', '	', '	' ), '', $buffer );
	return $buffer;
}




// Share Network Story
function share_story_network_link( $network, $id, $class = '', $icon = false ) {
	global $post;

	$networks = array(
		'fb' => array(
			'url'		=> 'https://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . esc_attr( get_permalink() ) . '&p&#91;title&#93;=' . esc_attr( get_the_title() ),
			'tooltip'	=> __( 'Facebook', 'kalium' ),
			'icon'		=> 'facebook'
		),

		'tw' => array(
			'url'		=> 'https://twitter.com/home?status=' . esc_attr( get_the_title() . ' – ' . get_permalink() ),
			'tooltip'	=> __( 'Twitter', 'kalium' ),
			'icon'		 => 'twitter'
		),

		'gp' => array(
			'url'		=> 'https://plus.google.com/share?url=' . esc_attr( get_permalink() ),
			'tooltip'	=> __( 'Google+', 'kalium' ),
			'icon'		 => 'google-plus'
		),

		'tlr' => array(
			'url'		=> 'https://www.tumblr.com/share/link?url=' . esc_attr( get_permalink() ) . '&name=' . esc_attr( get_the_title() ) . '&description=' . esc_attr( get_the_excerpt() ),
			'tooltip'	=> __( 'Tumblr', 'kalium' ),
			'icon'		 => 'tumblr'
		),

		'lin' => array(
			'url'		=> 'https://linkedin.com/shareArticle?mini=true&amp;url=' . esc_attr( get_permalink() ) . '&amp;title=' . esc_attr( get_the_title() ),
			'tooltip'	=> __( 'LinkedIn', 'kalium' ),
			'icon'		 => 'linkedin'
		),

		'pi' => array(
			'url'		=> 'https://pinterest.com/pin/create/button/?url=' . esc_attr( get_permalink() ) . '&amp;description=' . esc_attr( get_the_title() ) . '&amp;' . ($id ? ('media=' . wp_get_attachment_url( get_post_thumbnail_id($id) )) : ''),
			'tooltip'	=> __( 'Pinterest', 'kalium' ),
			'icon'	 	 => 'pinterest'
		),

		'vk' => array(
			'url'		=> 'https://vkontakte.ru/share.php?url=' . esc_attr( get_permalink() ) . '&title=' . esc_attr( get_the_title() ) . '&description=' . esc_attr( get_the_excerpt() ),
			'tooltip'	=> __( 'VKontakte', 'kalium' ),
			'icon'	 	 => 'vk'
		),

		'em' => array(
			'url'		=> 'mailto:?subject=' . esc_attr( get_the_title() ) . '&amp;body=' . esc_attr(sprintf(__('Check out what I just spotted: %s', 'kalium'), esc_attr(get_permalink()))),
			'tooltip'	=> __( 'Email', 'kalium' ),
			'icon'		 => 'envelope-o'
		),

		'pr' => array(
			'url'		=> 'javascript:window.print();',
			'tooltip'	=> __( 'Print', 'kalium' ),
			'icon'		 => 'print'
		),
	);

	$network_entry = $networks[ $network ];

	ob_start();
	
	$new_window = true;
	
	if ( $network ) {
		$new_window = false;
	}
	?>
	<a class="<?php echo esc_attr( $network_entry['icon'] ); echo $class ? esc_attr( ' ' . $class ) : ''; ?>" href="<?php echo $network_entry['url']; ?>"<?php if ( $new_window ) : ?> target="_blank"<?php endif; ?>>
		<?php if ( $icon ) : ?>
			<i class="icon fa fa-<?php echo esc_attr( $network_entry['icon'] ); ?>"></i>
		<?php else : ?>
			<?php echo esc_html( $network_entry['tooltip'] ); ?>
		<?php endif; ?>
	</a>
	<?php
		
	$social_network_link = ob_get_clean();
	
	echo compress_text( $social_network_link );
}



// In case when GET_FIELD function doesn't exists
if ( ! function_exists( 'get_field' ) && is_array( get_option( 'active_plugins' ) ) && ! in_array( 'advanced-custom-fields/acf.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && ! is_admin() ) {
	function get_field( $field_id, $post_id = null ) {
		global $post;

		if ( is_numeric( $post_id ) ) {
			$post = get_post( $post_id );
		}

		return $post->{$field_id};
	}
}




// Load Laborator Font from Theme Options
function laborator_load_font() {
	$use_custom_font   = get_data( 'use_custom_font' );
	$use_tykekit_font  = get_data( 'use_tykekit_font' );
	
	if ( $use_tykekit_font ) {
		add_action( 'wp_print_scripts', 'laborator_typekit_embed_code' );
	}
	
	if ( ! $use_custom_font ) {
		// Load default font
		wp_enqueue_style( 'default-font', '//fonts.googleapis.com/css?family=Karla:400,700,400italic,700italic', null, null );
		return;
	}
	
	$primary_font_provider     = THEMEASSETS;
	$primary_font_path         = '';

	$secondary_font_provider   = '';
	$secondary_font_path       = '';

	$font_variants = apply_filters( 'kalium_google_font_variants', '300,400,500,700' );
	$font_charsets = apply_filters( 'kalium_google_font_subset', 'latin' );

		// Google Font
		$font_primary = get_data( 'font_primary' );
		$font_heading = get_data( 'font_heading' );

		if ( $font_primary && $font_primary != 'none' ) {
			$primary_font_provider = '//fonts.googleapis.com/css?family=';
			$primary_font_path = urlencode( $font_primary ) . ':' . $font_variants . '&subset=' . $font_charsets;
		}

		if ( $font_heading && $font_heading != 'none' ) {
			$secondary_font_provider = '//fonts.googleapis.com/css?family=';
			$secondary_font_path = urlencode( $font_heading ) . ':' . $font_variants . '&subset=' . $font_charsets;
		}
		

		// Custom Font
		$custom_primary_font_url  = get_data( 'custom_primary_font_url' );
		$custom_heading_font_url  = get_data( 'custom_heading_font_url' );

		if ( $custom_primary_font_url ) {
			$primary_font_provider = '';
			$primary_font_path = $custom_primary_font_url;
		}

		if ( $custom_heading_font_url ) {
			$secondary_font_provider = '';
			$secondary_font_path = $custom_heading_font_url;
		}
		

	// Font Resource URI
	$primary_font_resource_uri	 = $primary_font_provider . $primary_font_path;
	$secondary_font_resource_uri = $secondary_font_provider . $secondary_font_path;
	

	// Load Fonts
	$duplicate_fonts = $primary_font_resource_uri == $secondary_font_resource_uri;
	
	if ( $primary_font_path ) {
		wp_enqueue_style( 'primary-font', $primary_font_resource_uri, null, null );
	}

	if ( $secondary_font_path && $duplicate_fonts == false ) {
		wp_enqueue_style( 'secondary-font', $secondary_font_resource_uri, null, null );
	}

	// Show Custom CSS
	if ( $primary_font_path || $secondary_font_path ) {
		add_action( 'wp_print_scripts', 'laborator_show_custom_font' );
	}
}

function laborator_show_custom_font() {
	?><style><?php echo get_option( 'kalium_font_custom_css' ); ?></style><?php
}

function laborator_typekit_embed_code() {
	echo get_data( 'typekit_embed_code' );
}


// Get Excerpt
function laborator_get_excerpt( $text ) {
	$excerpt_length  = apply_filters( 'excerpt_length', 55 );
	$excerpt_more	 = apply_filters( 'excerpt_more', ' [&hellip;]' );
	$text			 = apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', wp_trim_words( $text, $excerpt_length, $excerpt_more ) ) );

	return $text;
}


// Post Formats | Extract Content
function laborator_extract_post_content( $type, $replace_original = false, $meta = array() ) {
	global $post, $post_title, $post_excerpt, $post_content, $blog_post_formats;

	$content = array(
		'content' => '',
		'data'    => array()
	);

	if ( ! $post ) {
		return $content;
	}
	
	switch ( $type ) {
		
		case 'quote':

			if ( preg_match( "/^\s*<blockquote.*?>(.*?)<\/blockquote>/s", $post_content, $matches ) ) {
				$blockquote = lab_esc_script( wpautop( $matches[1] ) );

				// Replace Original Content
				if ( $replace_original ) {
					$post_excerpt = laborator_get_excerpt( str_replace( $matches[0], '', $post_content ) );
					$post_content = str_replace( $matches[0], '', $post_content );
				}

				if ( preg_match( "/(<br.*?>\s*)?<cite>(.*?)<\/cite>/s", $blockquote, $blockquote_matches ) ) {
					$cite = $blockquote_matches[2];
					$blockquote = str_replace( $blockquote_matches[0], '', $blockquote );

					// Add attributes
					$content['data']['cite'] = $cite;
				}

				// Set content
				$content['content'] = $blockquote;
			} else {
				$post_content_lines = explode( PHP_EOL, $post_content );
				$blockquote = reset( $post_content_lines );

				$content['content'] = $blockquote;

				// Replace Original Content
				if ( $replace_original ) {
					$post_content = str_replace( $blockquote, '', $post_content );
					$post_excerpt = laborator_get_excerpt( $post_content );
				}
			}

			break;

		case 'image':
					
			$image_url           = '';
			$post_content_lines  = explode( PHP_EOL, trim( $post_content ) );
			$first_line          = reset( $post_content_lines );
			
			// Match the image
			if ( preg_match( "/<img(.*?)>/", $first_line, $matches ) && preg_match( "/src=(\"|')([^'\"]+)(\"|')/i", $matches[1], $matches2 ) ) {
				$image_url = $matches2[2];
			} elseif ( preg_match( '/https?:\/\/[^\s\"\']+/', $first_line, $matches ) ) {
				$image_url = $matches[0];
			}
			
			// Populate Image URL on data array
			if ( $image_url ) {
				$content['content'] = $image_url;
				
				// Replace the content line with Image Link (or tag)
				if ( $replace_original ) {
					$post_content = preg_replace( '/' . preg_quote( $first_line, '/' ) . '/', '', $post_content, 1 );
					$post_excerpt = laborator_get_excerpt( $post_content );
				}
			}

			break;

		case 'link':

			$has_url = laborator_get_url_in_content( get_the_content() );
			$has_url = $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );

			$content['content'] = $has_url;
				
			// Replace the content line with Image Link (or tag)
			if ( $replace_original && $has_url ) {
				$post_content = preg_replace( '/' . preg_quote( $has_url, '/' ) . '/', '', $post_content, 1 );
				$post_excerpt = laborator_get_excerpt( $post_content );
			}
			break;

		case 'video':
			
			global $wp_embed;
				
			// Video Poster
			if ( isset( $meta['poster'] ) ) {
				$fn_code  = 'if ( get_the_ID() != ' . $post->ID . ' ) return $atts;';
				$fn_code .= '$atts["poster"] = "' . addslashes( $meta['poster'] ) . '";';
				$fn_code .= 'return $atts;';
				
				$fn_poster = create_function( '$atts', $fn_code );
				
				add_filter( 'kalium_video_shortcode_container_atts', $fn_poster );
			}
			
			// Auto Play
			if ( is_single() && isset( $meta['autoPlay'] ) ) {
				$fn_code  = 'if ( get_the_ID() != ' . $post->ID . ' ) return $atts;';
				$fn_code .= '$atts["autoplay"] = ' . ( $meta['autoPlay'] ? '1' : '0' ). ';';
				$fn_code .= 'return $atts;';
				
				$fn_autoplay = create_function( '$atts', $fn_code );
				add_filter( 'kalium_video_shortcode_container_atts', $fn_autoplay );
			}
			
			// Self Hosted Video
			if ( preg_match( "/\[video.*?\[\/video\]/s", $post->post_content, $matches ) ) {
				$video_shortcode = $matches[0];
				
				// Populate data
				$content['data']['type'] = 'native';
				$content['content'] = do_shortcode( $video_shortcode );
				
				// Remove shortcode from "the_content"
				if ( $replace_original ) {
					$post_content = str_replace( $video_shortcode, '', $post_content );
					$post_excerpt = laborator_get_excerpt( $post_content );
				}
				
			}  elseif ( $wp_embed ) {
				global $wp_embed;
				
				$post_content_lines = explode( PHP_EOL, $post->post_content );
				$first_line = strip_tags( trim( reset( $post_content_lines ) ) );
				
				// Parse Video from YouTube or Vimeo
				if ( preg_match( "/(https?:\/\/(www\.)?youtube.com[^\s\[]+)/s", $first_line, $matches ) || preg_match( "/(https?:\/\/(www\.)?vimeo.com[^\s\[]+)/s", $first_line, $matches ) ) {
					
					$content['data']['type'] = strpos( 'vimeo', $first_line ) >= 0 ? 'vimeo' : 'youtube';
					$content['content'] = $wp_embed->autoembed( $matches[0] );
					
					// Remove shortcode from "the_content"
					if ( $replace_original ) {
						$post_content = str_replace( $first_line, '', $post_content );
						$post_excerpt = laborator_get_excerpt( $post_content );
					}
				}
			}
			
			// Remove assigned filters
			if ( ! empty( $fn_poster ) ) {
				remove_filter( 'kalium_video_shortcode_container_atts', $fn_poster );
			}
			
			if ( ! empty( $fn_autoplay ) ) {
				remove_filter( 'kalium_video_shortcode_container_atts', $fn_autoplay );
			}

			break;

		case 'audio':

			if ( preg_match( "/\[audio.*?(https?[^\s]+?)\](\[\/audio\])?/s", $post->post_content, $matches ) ) {
				$audio_shortcode = $matches[0];
				
				// Audio Poster
				if ( isset( $meta['poster'] ) ) {
					$fn_code  = 'if ( get_the_ID() != ' . $post->ID . ' ) return $atts;';
					$fn_code .= '$atts["poster"] = "' . addslashes( $meta['poster'] ) . '";';
					$fn_code .= 'return $atts;';
					
					$fn_poster = create_function( '$atts', $fn_code );
					
					add_filter( 'kalium_audio_shortcode_container_atts', $fn_poster );
				}
			
				// Auto Play
				if ( is_single() && isset( $meta['autoPlay'] ) ) {
					$fn_code  = 'if ( get_the_ID() != ' . $post->ID . ' ) return $atts;';
					$fn_code .= '$atts["autoplay"] = ' . ( $meta['autoPlay'] ? '1' : '0' ). ';';
					$fn_code .= 'return $atts;';
					
					$fn_autoplay = create_function( '$atts', $fn_code );
					add_filter( 'kalium_audio_shortcode_container_atts', $fn_autoplay );
				}

				// Parse audio shortcode
				$content['content'] = do_shortcode( $audio_shortcode );

				// Remove shortcode from "the_content"
				if ( $replace_original ) {
					$post_content = str_replace( $audio_shortcode, '', $post_content );
					$post_excerpt = laborator_get_excerpt( $post_content );
				}
			
				// Remove assigned filters
				if ( ! empty( $fn_autoplay ) ) {
					remove_filter( 'kalium_video_shortcode_container_atts', $fn_autoplay );
				}
			}

			break;
	}

	return $content;
}


// Endless Pagination
function laborator_show_endless_pagination( $args = array() ) {
	$defaults = array(
		'per_page'    => get_option( 'posts_per_page' ),

		'opts'        => array(),
		'action'      => '',
		'callback'    => '',

		'class'       => 'text-' . get_data( 'blog_pagination_position' ),
		'reveal'      => false,

		'current'     => 1,
		'maxpages'    => 1,

		'more'        => __( 'Show More', 'kalium' ),
		'finished'    => __( 'No more posts to show', 'kalium' ),

		'type'        => 1,
		
		'visible'	  => true
	);

	if ( is_array( $args ) ) {
		$args = array_merge( $defaults, $args );
	}

	extract( $args );

	$type = str_replace( '_', '', $type );
	
	// Visibility
	if ( ! $visible ) {
		$class .= ' not-visible';
	}
	?>
	<div class="endless-pagination<?php echo " {$class}"; ?>">
		<div class="show-more<?php echo " type-{$type}"; echo esc_attr( $reveal ) ? ' auto-reveal' : ''; ?>" data-cb="<?php echo esc_attr( $callback ); ?>" data-action="<?php echo esc_attr( $action ); ?>" data-current="<?php echo esc_attr( $current ); ?>" data-max="<?php echo esc_attr( $maxpages ); ?>" data-pp="<?php echo esc_attr( $per_page ); ?>" data-opts="<?php echo esc_attr( json_encode( $opts ) ); ?>">
			<div class="button">
				<a href="#" class="btn btn-white">
					<?php echo esc_html( $more ); ?>

					<span class="loading">
					<?php
					switch ( $type ) :
						case 2:
							echo '<i class="loading-spinner-1"></i>';
							break;

						default:
							echo '<i class="fa fa-circle-o-notch fa-spin"></i>';
					endswitch;
					?>
					</span>

					<span class="finished">
						<?php echo esc_html( $finished ); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
	<?php
}

// Rot 13 Encrypt/Descript
function rot13encrypt( $str ) {
	return base64_encode( $str );
	//return str_rot13( base64_encode( $str ) ); // Deprecated
}

function rot13decrypt( $str ) {
	return base64_decode( $str );
	//return base64_decode( str_rot13( $str ) ); // Deprecated
}

function lab_rot13_tourl_encrypt( $data ) {
	return urlencode( rot13encrypt( serialize( $data ) ) );
}

function lab_rot13_tourl_decrypt( $data ) {
	return unserialize( rot13decrypt( $data ) );
}


// Generate Aspect Ratio Padding for an element, suitable for responsive also
function laborator_generate_aspect_ratio_css( $selector, $size = array() ) {
	
	if ( ! ( is_array( $size ) && count( $size ) == 2 || is_numeric( $size[0] ) || is_numeric( $size[1] ) && $size[0] > 0 ) ) {
		return;
	}

	$css  = 'padding-top: ' . number_format( $size[1]/$size[0] * 100, 6 ) . '%;';
	$css .= 'margin-top: -' . number_format( $size[1]/$size[0] * 100, 6 ) . '%;';

	generate_custom_style( $selector, $css );
}

// Aspect Ratio Element Generator
global $as_element_id;

$as_element_id = 1;

function laborator_generate_as_element( $size ) {
	global $as_element_id;
	
	if ( isset( $size['width'] ) ) {
		$size[0] = $size['width'];
	}
	
	if ( isset( $size['height'] ) ) {
		$size[1] = $size['height'];
	}

	if ( $size[0] == 0 ) {
		return null;
	}

	$element_id = "arel-" . $as_element_id;
	$padding_top = 'padding-top: ' . number_format( $size[1]/$size[0] * 100, 6 ) . '% !important;';
	$as_element_id++;

	if ( defined( 'DOING_AJAX' ) ) {
		$element_id .= '-' . time() . mt_rand(10000, 999999);
	}

	generate_custom_style( ".{$element_id}", $padding_top );

	return $element_id;
}


// Load Image with Aspect Ratio Container
function laborator_show_image_placeholder( $attachment_id, $size = 'original', $class = '', $lazy_load = true, $img_class = 'visibility-hidden' ) {
	
	if ( is_string( $size ) && preg_match( '/^[0-9]+(x[0-9]+)?$/', $size ) ) {
		$size = explode( 'x', $size );
	}

	if ( is_array( $size ) ) {
		if ( count( $size ) == 2 ) {
			$size['bfi_thumb']   = true;
			$size['crop']        = true;
			$size['quality']     = apply_filters( 'kalium_bfi_thumb_quality', 90 );
			
			// Calculate Width or Height
			if ( array_product( $size ) == 0 ) {
				$img_dims = wp_get_attachment_image_src( $attachment_id, 'original' );
				
				if ( ! empty( $img_dims ) && is_array( $img_dims ) ) {
					
					// Resize by width
					if ( ! $size[1] ) {
						$r = $size[0] / $img_dims[1];
						$size[1] = $r * $img_dims[2];
					}
					
					// Resize by height
					if ( ! $size[0] ) {
						$r = $size[1] / $img_dims[2];
						$size[0] = $r * $img_dims[1];
					}
				}
			}
		}
	}

	if ( is_numeric( $attachment_id ) ) {
		$image = wp_get_attachment_image_src( $attachment_id, $size );
		$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		$extension = pathinfo( $image[0], PATHINFO_EXTENSION );
		
		// When JetPack Photon Module is active, get image size from the URL
		if ( ! empty( $image[0] ) && ( empty( $image[1] ) || empty( $image[2] ) ) && preg_match( "/[a-z0-9-]+\.wp\.com\//", $image[0] ) ) {
			
			$url_args = wp_parse_args( preg_replace( '/.*?\?/', '', $image[0] ) );
			
			if ( ! empty( $url_args ) && is_array( $url_args ) && isset( $url_args['resize'] ) && preg_match( '/^[0-9]+,[0-9]+$/', $url_args['resize'] ) ) {
				$resize = explode( ',', $url_args['resize'] );
				$image[1] = $resize[0];
				$image[2] = $resize[1];
			} else {			
				$image_dimensions = @getimagesize( $image[0] );
				
				if ( is_array( $image_dimensions ) && count( $image_dimensions ) >= 2 ) {
					$image[1] = $image_dimensions[0];
					$image[2] = $image_dimensions[1];
				}
			}
		}
		
		// SVG Support
		$pathinfo_image = pathinfo( $image[0] );
		
		if ( $extension == 'svg' && function_exists( 'simplexml_load_file' ) ) {
			$svgfile = simplexml_load_file( $image[0] );
			
			if ( isset( $svgfile->rect ) ) {
				$width = reset( $svgfile->rect['width'] );
				$height = reset( $svgfile->rect['height'] );
				
				$image = array( $image[0], $width, $height );
			}
		}
		
		// Show gifs in original size
		if ( $extension == 'gif' ) {
			$image = wp_get_attachment_image_src( $attachment_id, 'full' );
		}
	} else {
		$image = array( $attachment_id, $size[0], $size[1] );
	}
	
	$image = apply_filters( 'laborator_show_image_placeholder_image_arr', $image );
	
	if ( is_array( $image ) ) {
		$image = array_filter( $image );
	}
	
	if ( empty( $image ) ) {
		$image[1] = $image[2] = 1;
	}

	$thumb_size	= array( $image[1], $image[2] );
	$element_id	= laborator_generate_as_element( $thumb_size );

	$placeholder_class = array();
	$placeholder_class[] = 'image-placeholder';
	$placeholder_class[] = $element_id;

	if ( $class ) {
		$placeholder_class[] = trim( $class );
	}
	
	if ( ! $lazy_load ) {
		$img_class = str_replace( 'visibility-hidden', 'img-loaded', $img_class );
	}
	?>
	<span class="<?php echo implode( ' ', apply_filters( 'lab_image_placeholder_class', $placeholder_class ) ); ?>">
		<img <?php echo apply_filters( 'lab_image_placeholder_lazyload', $lazy_load ) ? 'data-' : ''; ?>src="<?php echo esc_url( apply_filters( 'laborator_show_image_placeholder_url', $image[0] ) ); ?>" width="<?php echo esc_attr( $thumb_size[0] ); ?>" height="<?php echo esc_attr( $thumb_size[1] ); ?>" class="<?php echo esc_attr( $img_class ); ?>" alt="<?php echo esc_attr( ( ! empty( $alt ) ? $alt : "img-{$attachment_id}" ) ); ?>" />
	</span>
	<?php
}

function get_laborator_show_image_placeholder( $attachment_id, $size = 'original', $class = '', $lazy_load = true, $img_class = 'visibility-hidden' ) {
	ob_start();
	
	laborator_show_image_placeholder( $attachment_id, $size, $class, $lazy_load, $img_class );
	
	$image = ob_get_clean();
	
	return $image;
}


// Custom Style Generator
global $bottom_styles;

$bottom_styles = array();

function generate_custom_style( $selector, $props = '', $media = '', $footer = false ) {
	global $bottom_styles;

	$css = '';

		// Selector Start
		$css .= $selector . ' {' . PHP_EOL;

			// Selector Properties
		$css .= str_replace( ';', ';' . PHP_EOL, $props );

		$css .= PHP_EOL . '}';
		// Selector end


	if ( ! $footer || defined( 'DOING_AJAX' ) ) {
		echo "<style>{$css}</style>";
		return;
	}

	$bottom_styles[] = $css;
}

add_action( 'wp_footer', create_function( '', 'global $bottom_styles; if ( ! count($bottom_styles)) return; echo "<style>\n" . compress_text(implode(PHP_EOL . PHP_EOL, $bottom_styles)) . "\n</style>"; ' ) );


// User IP
function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}





// Get SVG
function lab_get_svg( $svg_path, $id = null, $size = array( 24, 24 ), $is_asset = true ) {
	if ( $is_asset ) {
		$svg_path = get_template_directory() . '/assets/' .  $svg_path;
	}

	if ( ! $id ) {
		$id = sanitize_title( basename( $svg_path ) );
	}

	if ( is_numeric( $size ) ) {
		$size = array( $size, $size );
	}

	ob_start();

	echo file_get_contents( $svg_path );

	$svg = ob_get_clean();

	$svg = preg_replace(
		array(
			'/^.*<svg/s',
			'/id=".*?"/i',
			'/width=".*?"/',
			'/height=".*?"/'
		),
		array(
			'<svg', 'id="' . $id . '"',
			'width="' . $size[0] . 'px"',
			'height="' . $size[0] . 'px"'
		),
		$svg
	);

	return $svg;
}






// Get Image Size from HTML
function laborator_get_image_size_from_html( $html ) {
	$size = array(
		'width' => '',
		'height' => ''
	);
	
	if ( preg_match( "/width=.([0-9]+)./", $html, $matches ) ) {
		$size['width'] = $matches[1];
	}
	
	if ( preg_match( "/height=.([0-9]+)./", $html, $matches ) ) {
		$size['height'] = $matches[1];
	}
	
	return $size;
}




// Get Main Menu
function laborator_get_main_menu( $menu_location = 'main-menu' ) {
	if ( $menu_location == '' || $menu_location == '-' ) {
		return '';
	}
	
	$args = array(
		'container'       => '',
		'theme_location'  => $menu_location,
		'echo'            => false
	);
	
	if ( is_numeric( $menu_location ) ) {
		$args['menu'] = $menu_location;
		unset( $args['theme_location'] );
	}
	
	return wp_nav_menu( $args );
}


// Less Generator
function kalium_generate_less_style( $files = array(), $vars = array() ) {
	try {
		@ini_set( 'memory_limit', '256M' );
		
		if ( ! class_exists( 'Less_Parser' ) ) {
			include_once THEMEDIR . 'inc/lib/lessphp/Less.php';
		}
		
		$skin_generator = file_get_contents( THEMEDIR . 'assets/less/skin-generator.less' );
		
		// Compile Less
		$less_options = array(
			'compress' => true
		);
		
		$css = '';
				
		$less = new Less_Parser( $less_options );
		
		foreach ( $files as $file => $type ) {
			if ( $type == 'parse' ) {
				$css_contents = file_get_contents( $file );
				
				// Replace Vars
				foreach ( $vars as $var => $value ) {
					if ( trim( $value ) ) {
						$css_contents = preg_replace( "/(@{$var}):\s*.*?;/", '$1: ' . $value . ';', $css_contents );
					}
				}
				
				$less->parse( $css_contents );
			} else {
				$less->parseFile( $file );
			}
		}
		
		$css = $less->getCss();
	} catch( Exception $e ) {
	}
	
	return $css;
}



// Hex to Rgb with Alpha
function labHex2Rgba( $color, $opacity = false ) {
	$default = 'rgb(0,0,0)';
 
	if ( empty( $color ) ) {
		return $default;
	}
 
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	$rgb =  array_map( 'hexdec', $hex );

	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ",", $rgb ) . ')';
	}

	return $output;
}


// Escape script tag
function lab_esc_script( $str = '' ) {
	$str = str_ireplace( array( '<script', '</script>' ), array( '&lt;script', '&lt;/script&gt;' ), $str );
	return $str;
}

// Escape script plus strip tags
function lab_strip_script( $str = '', $tags = '' ) {
	$str = strip_tags( $str, $tags );
	return lab_esc_script( $str );
}

// Round Up To Any
function roundUpToAny( $n, $x = 5 ) {
	return ( ceil( $n ) % $x === 0) ? floor( $n ) : round( ( $n + $x / 2 ) / $x ) * $x;
}

// Starts with
function startsWith( $haystack, $needle ) {
	$length = strlen( $needle );
	return ( substr( $haystack, 0, $length ) === $needle );
}


// Shop Supported
function is_shop_supported() {
	return is_array( get_option( 'active_plugins' ) ) && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}


// Is ACF Pro Activated

	function is_acf_pro_activated() {
		return is_array( get_option( 'active_plugins' ) ) && in_array( 'advanced-custom-fields-pro/acf.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}


// Show Menu Bar (Hambuger Icon)
function hamburger_menu_icon_or_label() {
	$menu_hamburger_custom_label = get_data( 'menu_hamburger_custom_label' );
	
	if ( $menu_hamburger_custom_label ) {
		
		$label_show_text = get_data( 'menu_hamburger_custom_label_text' );
		$label_close_text = get_data( 'menu_hamburger_custom_label_close_text' );
		$icon_position = get_data( 'menu_hamburger_custom_icon_position', 'left' );
		
		?>
		<span class="show-menu-text icon-<?php echo esc_attr( $icon_position ); ?>"><?php echo $label_show_text; ?></span>
		<span class="hide-menu-text"><?php echo $label_close_text; ?></span>
		
		<span class="ham"></span>
		<?php
		
	} else {	
		?>
		<span class="ham"></span>
		<?php
	}
}


// Generate Unique ID
function lab_unique_id( $prepend = 'el-' ) {
	$uniqueid = $prepend . ( function_exists( 'uniqid' ) ? uniqid() : '' ) . time() . mt_rand( 10000, 99999 );
	return $uniqueid;
}


// Get Available Terms for current WP_Query object
function lab_get_available_terms_for_query( $args, $taxonomy = 'category' ) {
	
	global $wpdb;
	
	// Remove pagination argument
	if ( isset( $args['paged'] ) ) {
		unset( $args['paged'] );
	}
	
	$ids = new WP_Query( array_merge( $args, array(
		'fields'          => 'ids',
		'posts_per_page'  => -1
	) ) );
	
	$ids = $ids->posts; // Posts Array
	
	$object_terms = wp_get_object_terms( $ids, $taxonomy );
	
	if ( is_array( $object_terms ) && isset( $object_terms[0] ) && $object_terms[0] instanceof WP_Term && isset( $object_terms[0]->term_order ) ) {
		uasort( $object_terms, 'kalium_sort_terms_taxonomy_order_fn' );
	}
	
	return $object_terms;
}

function kalium_sort_terms_taxonomy_order_fn( $a, $b ) {
	return $a->term_order > $b->term_order ? 1 : -1;
}


// Show Subcategories for the current Term
function lab_get_terms_by_parent_id( $parent_term, $args ) {
	
	extract( $args ); // $available_terms, $portfolio_url, $category_slug, $current_category, $is_page_type
	
	$sub_terms = array();
	
	if ( empty( $available_terms ) || ! is_array( $available_terms ) ) {
		return;
	}
	
	foreach ( $available_terms as $term ) {
		if ( $term->parent == $parent_term->term_id ) {
			$sub_terms[] = $term;
		}
	}
	
	if ( ! count( $sub_terms ) ) {
		return;
	}
	
	// Go Back Link (Parent Category)
	$go_back_link = get_term_link( $parent_term, 'portfolio_category' );
	
	if ( $is_page_type ) {
		$go_back_link = $portfolio_url . '?' . $category_slug . '=' . $parent_term->slug;
	}
	
	?>
	<ul class="portfolio-subcategory" data-sub-category-of="<?php echo esc_attr( $parent_term->slug ); ?>">
		<li class="subcategory-back">
			<a href="<?php echo esc_url( $go_back_link ); ?>" class="subcategory-back-href" data-term="<?php echo esc_attr( $parent_term->slug ); ?>">
				<i class="fa fa-angle-left"></i>
				<span><?php echo sprintf( _x( '%s:', 'current portfolio subcategory', 'kalium' ), $parent_term->name ); ?></span>
			</a>
		</li>
		<?php 
		foreach ( $sub_terms as $term ) :
			$is_active = $current_category && $current_category == $term->slug;
			$term_link = get_term_link( $term, 'portfolio_category' );
			
			if ( $is_page_type ) {
				$term_link = $portfolio_url . '?' . $category_slug . '=' . $term->slug;
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
}


// Append content to the footer
add_action( 'wp_footer', 'laborator_append_content_to_footer_parse_content' );
$lab_footer_html = array();

function laborator_append_content_to_footer( $str ) {
	global $lab_footer_html;
	$lab_footer_html[] = $str;
}

function laborator_append_content_to_footer_parse_content() {
	global $lab_footer_html;
	echo implode( PHP_EOL, $lab_footer_html );
}


// File Based Custom Skin
function kalium_use_filebased_custom_skin() {
	$custom_skin_path = '/assets/css/custom-skin.css';
	
	if ( is_child_theme() ) {
		$custom_skin_path = '/custom-skin.css';
	}
	
	$custom_skin_path_full = get_stylesheet_directory() . $custom_skin_path;
	
	// Create skin file in case it does not exists
	if ( file_exists( $custom_skin_path_full ) === false ) {
		touch( $custom_skin_path_full );
	}
	
	if ( is_writable( $custom_skin_path_full ) === true ) {
		
		if ( ! trim( file_get_contents( $custom_skin_path_full ) ) ) {
			return kalium_generate_custom_skin_file();
		}
		
		return true;
	}
	
	return false;
}


// Generate Custom Skin File
function kalium_generate_custom_skin_file() {
	$custom_skin_path = get_stylesheet_directory() . '/assets/css/custom-skin.css';
	
	if ( is_child_theme() ) {
		$custom_skin_path = get_stylesheet_directory() . '/custom-skin.css';
	}
	
	if ( is_writable( $custom_skin_path ) ) {
		$kalium_skin_custom_css = get_option( 'kalium_skin_custom_css' );
		
		$fp = fopen( $custom_skin_path , 'w' );
		fwrite( $fp, $kalium_skin_custom_css );
		fclose( $fp );
		
		return true;
	}
	
	return false;
}


// Get URL in content
function laborator_get_url_in_content( $str ) {
	$url = '';
	$url_regex = '/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/im';
	
	if ( preg_match( $url_regex, $str, $matched_urls ) ) {
		return $matched_urls[0];
	}
	
	return $url;
}