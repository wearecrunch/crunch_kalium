<?php
/**
 *	Custom Row for this theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

add_action( 'vc_after_init', 'laborator_vc_row_options' );
add_action( 'vc_after_init', 'laborator_vc_row_full_width' );
add_action( 'vc_after_init', 'laborator_vc_row_container_wrap' );
add_action( 'vc_after_init', 'laborator_vc_row_no_margin' );

function laborator_vc_row_options() {
	
	# Parallax Attributes
	$parallax_attributes = array(
	   array(
			'type'           => 'checkbox',
			'heading'        => __( 'Laborator Parallax', 'lab_composer' ),
			'param_name'     => 'parallax_enable',
			'value'          => array( __( 'Yes', 'lab_composer' ) => 'yes' ),
			'description'    => 'Check this box if you want to enable parallax for this row.',
			'dependency' => array(
				'element'   => 'parallax',
				'is_empty' 	=> true,
			),
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Laborator Parallax Ratio', 'lab_composer' ),
			'param_name'     => 'parallax_ratio',
			'value'          => '0.8',
			'description'    => __( 'Recommended scale: from 0.00 to 1.00.', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Laborator Parallax Opacity', 'lab_composer' ),
			'param_name'     => 'parallax_opacity',
			'value'          => '',
			'description'    => __( 'Opacity to reach while exiting the viewport. Recommended scale: from 0.00 to 1.00. (Optional)', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
	);
	
	vc_add_params( 'vc_row', $parallax_attributes );
}

function laborator_vc_row_full_width()  {
	
	# Full Width Param
	$param = WPBMap::getParam( 'vc_row', 'full_width' );
	
	$param['weight'] = 2;
	$param['value'][ __('Full width (Laborator)', 'lab_composer') ] = 'lab-full-width';

	vc_update_shortcode_param( 'vc_row', $param );
}

function laborator_vc_row_container_wrap() {
	
	vc_add_param( 'vc_row', array(
		'type'           => 'checkbox',
		'heading'        => __( 'Wrap within container', 'lab_composer' ),
		'param_name'     => 'container_wrap',
		'value'          => array( __( 'Yes', 'lab_composer' ) => 'yes' ),
		'description'    => 'Check this box if you want to wrap contents of this row within default container.',
		'dependency' => array(
			'element'   => 'full_width',
			'value'     => array( 'lab-full-width' )
		),
		'weight' => 1
	) );
}

function laborator_vc_row_no_margin()  {
	
	vc_add_param( 'vc_row', array(
		'type'           => 'checkbox',
		'heading'        => __( 'No Bottom Margin', 'lab_composer' ),
		'param_name'     => 'no_bottom_margin',
		'value'          => array( __( 'Yes', 'lab_composer' ) => 'yes' ),
		'description'    => 'Check this box if you want to remove the bottom margin of this row.',
		'weight'		 => 1
	) );
}