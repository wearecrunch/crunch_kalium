<?php
/**
 *	Dribbble Gallery
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'dribbble.png';


vc_map( array(
	'base'             => 'lab_dribbble_gallery',
	'name'             => __('Dribbble Gallery', 'lab_composer'),
	"description"      => __("Profile shots", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Dribbble Username', 'lab_composer' ),
			'param_name'     => 'username',
			'admin_label'    => true,
			'description'    => __( 'Enter Dribbble account username to fetch shots.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Dribbble Access Token', 'lab_composer' ),
			'param_name'     => 'access_token',
			'description'    => __( 'Dribbble API requires this information in order to work properly. To create an application <a href="http://developer.dribbble.com/" target="_blank">click here</a>.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Shots Count', 'lab_composer' ),
			'param_name'     => 'count',
			'value'     	 => '9',
			'description'    => __( 'Number of shots to retrieve. (Max: 12)', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Columns', 'lab_composer' ),
			'admin_label'    => true,
			'param_name'     => 'columns',
			'std'            => 'three',
			'value'          => array(
				__('3 Items per Row', 'lab_composer')    => 'three',
				__('4 Items per Row', 'lab_composer')    => 'four',
			),
			'description' => __( 'Number of columns to show dribbble shots.', 'lab_composer' )
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

class WPBakeryShortCode_Lab_Dribbble_Gallery extends WPBakeryShortCode {}