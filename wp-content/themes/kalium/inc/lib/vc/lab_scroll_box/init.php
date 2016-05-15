<?php
/**
 *	Scroll Box
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'scrollbox.png';


vc_map( array(
	'base'             => 'lab_scroll_box',
	'name'             => __('Scroll Box', 'lab_composer'),
	"description"      => __("Content with scrollbar", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Height', 'lab_composer' ),
			'param_name'     => 'scroll_height',
			'description'	 => __('Set the maximum height of content box, scrollbar will be visible when there is more text.', 'lab_composer'),
			'admin_label'    => true,
			'value'          => '450'
		),
		array(
			'type'       => 'textarea_html',
			'heading'    => __( 'Content', 'lab_composer' ),
			'param_name' => 'content',
			'value'      => ''
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

class WPBakeryShortCode_Lab_Scroll_Box extends WPBakeryShortCode {}