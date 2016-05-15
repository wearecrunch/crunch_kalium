<?php
/**
 *	Heading Title
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'heading.png';


vc_map( array(
	'base'             => 'lab_heading',
	'name'             => __('Heading', 'lab_composer'),
	"description"      => __("Title and description", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'    => true,
			'value'          => 'Heading title'
		),
		array(
			'type'       => 'textarea',
			'heading'    => __( 'Content', 'lab_composer' ),
			'param_name' => 'content',
			'value'      => 'Enter your description about the heading title here.'
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

class WPBakeryShortCode_Lab_Heading extends WPBakeryShortCode {}