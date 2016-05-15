<?php
/**
 *	Portfolio Items
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'portfolio.png';


# Portfolio Items
vc_map( array(
	'base'             => 'lab_portfolio_items',
	'name'             => __('Portfolio Items', 'lab_composer'),
	"description"      => __("Show portfolio items", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type' => 'loop',
			'heading' => __( 'Portfolio Items', 'lab_composer' ),
			'param_name' => 'portfolio_query',
			'settings' => array(
				'size' => array('hidden' => false, 'value' => 4 * 3),
				'order_by' => array('value' => 'date'),
				'post_type' => array('value' => 'portfolio', 'hidden' => false)
			),
			'description' => __( 'Create WordPress loop, to populate content from your site.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Portfolio Type', 'lab_composer' ),
			'admin_label'    => true,
			'param_name'     => 'portfolio_type',
			'std'            => 'type-1',
			'value'          => array(
				__('Thumbnails with Visible Titles', 'lab_composer')    => 'type-1',
				__('Thumbnails with Titles Inside', 'lab_composer')     => 'type-2',
			),
			'description' => __( 'Select portfolio type to show items.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Columns', 'lab_composer' ),
			'admin_label'    => true,
			'param_name'     => 'columns',
			'std'            => 'four',
			'value'          => array(
				__('2 Items per Row', 'lab_composer')    => 'six',
				__('3 Items per Row', 'lab_composer')    => 'four',
				__('4 Items per Row', 'lab_composer')    => 'three',
			),
			'description' => __( 'Number of columns to show portfolio items.', 'lab_composer' )
		),
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
			'type'           => 'dropdown',
			'heading'        => __( 'Item Spacing', 'lab_composer' ),
			'param_name'     => 'portfolio_spacing',
			'description'    => __( 'Spacing between portfolio items.', 'lab_composer' ),
			'std'			 => 'inherit',
			'value'          => array(
				__('Inherit from Theme Options', 'lab_composer')    => 'inherit',
				__('Yes', 'lab_composer')                       => 'yes',
				__('No', 'lab_composer')                        => 'no',
			),
			'dependency' => array(
				'element'   => 'portfolio_type',
				'value' => array('type-2')
			),
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Dynamic Image Height', 'lab_composer' ),
			'param_name'     => 'dynamic_image_height',
			'description'    => __( 'Use proportional image height for each item.', 'lab_composer' ),
			'std'			 => 'no',
			'value'          => array(
				__('Yes', 'lab_composer')    => 'yes',
				__('No', 'lab_composer')     => 'no',
			),
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
			'admin_label'    => true,
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
	)
) );

class WPBakeryShortCode_Lab_Portfolio_Items extends WPBakeryShortCode {}