<?php
/**
 *	Blog Posts Shortcode
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'blog-posts.png';


vc_map( array(
	'base'             => 'lab_blog_posts',
	'name'             => __('Blog Posts', 'lab_composer'),
	"description"      => __("Show blog posts", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			"type" => "loop",
			"heading" => __("Blog Query", 'lab_composer'),
			"param_name" => "blog_query",
			'settings' => array(
				'size' => array('hidden' => false, 'value' => 3),
				'order_by' => array('value' => 'date'),
				'post_type' => array('value' => 'post', 'hidden' => false)
			),
			"description" => __("Create WordPress loop, to populate only blog posts from your site.", 'lab_composer')
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns', 'lab_composer' ),
			'param_name' => 'columns',
			'std' => '3',
			'admin_label' => true,
			'value' => array(
				__( '1 Column', 'lab_composer' )    => '1',
				__( '2 Columns', 'lab_composer' )   => '2',
				__( '3 Columns', 'lab_composer' )   => '3',
				__( '4 Columns', 'lab_composer' )   => '4',
			),
			'description' => __( 'Set number of columns to separate blog posts.', 'lab_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout', 'lab_composer' ),
			'param_name' => 'layout',
			'std' => 'top',
			'admin_label' => true,
			'value' => array(
				__( 'Image on Top', 'lab_composer' )   => 'top',
				__( 'Image on Left', 'lab_composer' )   => 'left',
			),
			'description' => __( 'Set posts layout to show blog posts.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Image Column Width', 'lab_composer' ),
			'param_name'     => 'image_column_size',
			'description'    => __( 'Set column width for the image, unit is percentage.', 'lab_composer' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'left', 'right' )
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Image Size', 'lab_composer' ),
			'param_name'     => 'image_size',
			'description'    => __( 'Set image size dimensions to show blog posts featured image. Default is: 400x320.', 'lab_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Masonry', 'lab_composer' ),
			'param_name' => 'masonry',
			'std' => 'plain',
			'value' => array(
				__( 'Plain', 'lab_composer' )                   => 'plain',
				__( 'Masonry Mode', 'lab_composer' )            => 'masonry',
				__( 'Masonry Fit Rows Mode', 'lab_composer' )   => 'fitRows',
			),
			'description' => __( 'Set grid render for blog posts.', 'lab_composer' )
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Blog Post Toggles', 'lab_composer' ),
			'param_name'     => 'blog_posts_options',
			'std'            => '',
			'value'          => array(
				__('Show Post Date<br />', 'lab_composer') => 'date',
				__('Animated Eye on Hover<br />', 'lab_composer') => 'animated-eye-hover',
			),
			'description'    => __( 'Toggle blog post options.', 'lab_composer' )
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'More Link', 'lab_composer' ),
			'param_name'     => 'more_link',
			'value'          => '',
			'description'	 => 'This will show "More" button in the end of blog items.'
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Extra class name', 'lab_composer' ),
			'param_name'     => 'el_class',
			'description'    => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'lab_composer' )
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'Css', 'lab_composer' ),
			'param_name' => 'css',
			'group'      => __( 'Design options', 'lab_composer' )
		)
	)
) );

class WPBakeryShortCode_Lab_Blog_Posts extends WPBakeryShortCode {}