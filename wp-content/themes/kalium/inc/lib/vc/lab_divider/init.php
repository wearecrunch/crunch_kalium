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
$lab_vc_element_icon    = $lab_vc_element_url . 'divider.png';


vc_map( array(
	'base'             => 'lab_divider',
	'name'             => __('Divider', 'lab_composer'),
	"description"      => __("Text or plain divider", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Type', 'lab_composer' ),
			'param_name' => 'type',
			'admin_label' => true,
			'std' => 'text',
			'value' => array(
				__( 'Plain', 'lab_composer' )           => 'plain',
				__( 'Text Divider', 'lab_composer' )    => 'text',
			),
			'description' => __( 'Select the type of divider, plain or text divider.', 'lab_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Divider Style', 'lab_composer' ),
			'param_name' => 'plain_style',
			'value' => array(
				__( 'Saw Border', 'lab_composer' )  => 'saw',
				__( 'Thin Dash', 'lab_composer' )   => 'thin',
				__( 'Thick Dash', 'lab_composer' )  => 'thick',
			),
			'description' => __( 'Select style of plain divider.', 'lab_composer' ),
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'plain' )
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Width', 'lab_composer' ),
			'param_name'     => 'plain_width',
			'description'    => __( 'Divider width in percentage unit 1-100, leave empty to use 100 percent as value.', 'lab_composer' ),
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'plain' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Divider Style', 'lab_composer' ),
			'param_name' => 'text_style',
			'value' => array(
				__( 'Thick', 'lab_composer' )           => '2',
				__( 'Dotted', 'lab_composer' )          => '5',
				__( 'Striped', 'lab_composer' )         => '6',
				__( 'Double Border', 'lab_composer' )   => '3',
				__( 'Shadowed', 'lab_composer' )        => '1',
				__( 'Inverese', 'lab_composer' )        => '4',
				__( 'Saw', 'lab_composer' )        		=> '7',
			),
			'description' => __( 'Select style of text divider.', 'lab_composer' ),
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'text' )
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'    => true,
			'description'    => __( 'Divider title to display in the center.', 'lab_composer' ),
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'text' )
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Color', 'lab_composer' ),
			'param_name'     => 'plain_color',
			'description'    => __( 'Set custom border color, leave empty to use default.', 'lab_composer' ),
			'dependency'     => array(
				'element' => 'plain_style',
				'value' => array( 'thin', 'thick' )
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Color', 'lab_composer' ),
			'param_name'     => 'text_color',
			'description'    => __( 'Set custom border color, leave empty to use default.', 'lab_composer' ),
			'dependency'     => array(
				'element' => 'text_style',
				'value' => array( '1', '2', '3', '4' )
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Text Color', 'lab_composer' ),
			'param_name'     => 'text_color_font',
			'description'    => __( 'Set custom text color, leave empty to use default.', 'lab_composer' ),
			'dependency'     => array(
				'element' => 'type',
				'value' => array( 'text' )
			),
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

class WPBakeryShortCode_Lab_Divider extends WPBakeryShortCode {}