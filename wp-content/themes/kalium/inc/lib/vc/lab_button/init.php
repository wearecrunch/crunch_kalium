<?php
/**
 *	Laborator Button
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'button.png';

$colors_arr = array(
	__( 'Primary', 'lab_composer' )    => 'btn-primary',
	__( 'Secondary', 'lab_composer' )  => 'btn-secondary',
	__( 'Black', 'lab_composer' )      => 'btn-black',
	__( 'Blue', 'lab_composer' )       => 'btn-blue',
	__( 'Red', 'lab_composer' )        => 'btn-red',
	__( 'Green', 'lab_composer' )      => 'btn-green',
	__( 'Yellow', 'lab_composer' )     => 'btn-yellow',
	__( 'White', 'lab_composer' )      => 'btn-white',
);

vc_map( array(
	'base'             => 'lab_button',
	'name'             => __('Button', 'lab_composer'),
	"description"      => __("Insert button link", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Button Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'    => true,
			'value'          => ''
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'Button Link', 'lab_composer' ),
			'param_name'     => 'link',
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Button Type', 'lab_composer' ),
			'param_name'     => 'type',
			'std'            => 'default',
			'admin_label'    => true,
			'value'          => array(
				__('Standard', 'lab_composer')                          => 'standard',
				__('Outlined', 'lab_composer')                          => 'outlined',
				__('Outlined with Hover Background', 'lab_composer')    => 'outlined-bg',
				__('Flip Hover', 'lab_composer')                        => 'fliphover',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Button Size', 'lab_composer' ),
			'param_name'     => 'size',
			'std'            => 'btn-normal',
			'value'          => array(
				__('Mini', 'lab_composer')      => 'btn-mini',
				__('Small', 'lab_composer')     => 'btn-small',
				__('Normal', 'lab_composer')    => 'btn-normal',
				__('Large', 'lab_composer')     => 'btn-large',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Background Color', 'lab_composer' ),
			'param_name'     => 'button_bg',
			'value'          => array_merge( $colors_arr, array( __( 'Custom color', 'lab_composer' ) => 'custom' ) ),
			'std'            => 'btn-primary',
			'description'    => __( 'Select button background (and/or border) color.', 'lab_composer' )
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Custom Background Color', 'lab_composer' ),
			'param_name'     => 'button_bg_custom',
			'description'    => __( 'Custom background color for button.', 'lab_composer' ),
			'dependency'     => array(
				'element'   => 'button_bg',
				'value'     => array( 'custom' )
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Custom Text Color', 'lab_composer' ),
			'param_name'     => 'button_txt_custom',
			'description'    => __( 'Custom text color for button.', 'lab_composer' ),
			'dependency'     => array(
				'element'   => 'button_bg',
				'value'     => array( 'custom' )
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Custom Text Color', 'lab_composer' ),
			'param_name'     => 'button_txt_hover_custom',
			'description'    => __( 'Custom text hover color for button (where applied).', 'lab_composer' ),
			'dependency'     => array(
				'element'   => 'button_bg',
				'value'     => array( 'custom' )
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

class WPBakeryShortCode_Lab_Button extends WPBakeryShortCode {}