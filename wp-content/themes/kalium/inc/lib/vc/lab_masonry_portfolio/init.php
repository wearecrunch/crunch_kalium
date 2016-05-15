<?php
/**
 *	Masonry Portfolio Items
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'masonry.png';


# Portfolio Items
vc_map( array(
	'base'                     => 'lab_masonry_portfolio',
	'name'                     => __('Masonry Portfolio', 'lab_composer'),
	"description"              => __("Custom portfolio boxes", "lab_composer"),
	"content_element"          => true,
	"show_settings_on_create"  => true,
	"as_parent"                => array('only' => 'lab_masonry_portfolio_item'),
	'category'                 => __('Laborator', 'lab_composer'),
	'icon'                     => $lab_vc_element_icon,
	'params'                   => array(
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Reveal Effect', 'lab_composer' ),
			'param_name'     => 'reveal_effect',
			'std'            => 'inherit',
			'value'          => array(
				__('Inherit from Theme Options', 'lab_composer')    => 'inherit',
				__('None', 'lab_composer')                          => 'none',
				__('Fade', 'lab_composer')                          => 'fade',
				__('Slide and Fade', 'lab_composer')                => 'slidenfade',
				__('Zoom In', 'lab_composer')                       => 'zoom',
				__('Fade (one by one)', 'lab_composer')             => 'fade-one',
				__('Slide and Fade (one by one)', 'lab_composer')   => 'slidenfade-one',
				__('Zoom In (one by one)', 'lab_composer')          => 'zoom-one',
			),
			'description' => __( 'Reveal effect for portfolio items.', 'lab_composer' )
		),
		
		array(
			'type' => 'dropdown',
			'param_name' => 'portfolio_spacing',
			'value' => array(
				__('Inherit from Theme Options', 'lab_composer')    => 'inherit',
				__('Yes', 'lab_composer')                           => 'yes',
				__('No', 'lab_composer')                            => 'no',
			),
			'heading' => __( 'Item Spacing', 'lab_composer' ),
			'description' => __( 'Spacing between portfolio items.', 'lab_composer' )
		),
		
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'More Link', 'lab_composer' ),
			'param_name'     => 'more_link',
			'value'          => '',
			'description'	 => 'This will show "More" button in the end of portfolio items.'
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'value'          => '',
			'description'	 => 'Main title of this widget. (Optional)'
		),
		array(
			'type'           => 'textarea',
			'heading'        => __( 'Description', 'lab_composer' ),
			'param_name'     => 'description',
			'value'          => '',
			'description'	 => 'Description under main portfolio title. (Optional)'
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Category Filter', 'lab_composer' ),
			'param_name'     => 'category_filter',
			'value'          => array(
				__('Yes', 'lab_composer') => 'yes',
				__('No', 'lab_composer')  => 'no',
			),
			'description'    => __( 'Show category filter above the portfolio items.', 'lab_composer' ),
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
	),
	"js_view" => 'VcColumnView'
) );


# Portfolio Item (child of Google Map)
$portfolio_items_list = array();

if(is_admin())
{
	$portfolio_items = get_posts(array(
		'post_type' => 'portfolio',
		'posts_per_page' => -1
	));
	
	foreach($portfolio_items as $portfolio)
	{
		$portfolio_items_list[$portfolio->post_title] = $portfolio->ID;
	}
}

vc_map( array(
	"base"             => "lab_masonry_portfolio_item",
	"name"             => __("Portfolio Item", "lab_composer"),
	"description"      => __("Insert single item", "lab_composer"),
	"category"         => __('Laborator', 'lab_composer'),
	"content_element"  => true,
	"icon"			   => $lab_vc_element_icon,
	"as_child"         => array('only' => 'lab_masonry_portfolio'),
	'admin_enqueue_js' => $lab_vc_element_url . 'init-lab-masonry.js',
	"params"           => array(
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Box Size', 'lab_composer' ),
			'admin_label'    => true,
			'param_name'     => 'box_size',
			'value'          => array(
				__('8 col - small', 'lab_composer')     => '8x3',
				__('8 col - medium', 'lab_composer')    => '8x4',
				__('8 col - large', 'lab_composer')     => '8x6',
				
				__('6 col - small', 'lab_composer')     => '6x3',
				__('6 col - medium', 'lab_composer')    => '6x4',
				__('6 col - large', 'lab_composer')     => '6x6',
				
				__('5 col - small', 'lab_composer')     => '5x3',
				__('5 col - medium', 'lab_composer')    => '5x4',
				__('5 col - large', 'lab_composer')     => '5x6',
				
				__('4 col - small', 'lab_composer')     => '4x3',
				__('4 col - medium', 'lab_composer')    => '4x4',
				__('4 col - large', 'lab_composer')     => '4x6',
				
				__('3 col - small', 'lab_composer')     => '3x3',
				__('3 col - medium', 'lab_composer')    => '3x4',
				__('3 col - large', 'lab_composer')     => '3x6',
				
				__('12 col - small', 'lab_composer')    => '12x4',
				__('12 col - medium', 'lab_composer')   => '12x5',
				__('12 col - large', 'lab_composer')    => '12x6',
				
				__('9 col - small', 'lab_composer')     => '9x3',
				__('9 col - medium', 'lab_composer')    => '9x4',
				__('9 col - large', 'lab_composer')     => '9x6',
			),
			'description' => __( 'Select portfolio type to show items.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Portfolio Item', 'lab_composer' ),
			'admin_label'    => true,
			'param_name'     => 'portfolio_id',
			'value'          => $portfolio_items_list,
			'description' => __( 'Select an item from portfolio to show in masonry grid. Duplicate Items will be removed.', 'lab_composer' )
		),
	)
) );

class WPBakeryShortCode_Lab_Masonry_Portfolio extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Lab_Masonry_Portfolio_Item extends WPBakeryShortCode {}