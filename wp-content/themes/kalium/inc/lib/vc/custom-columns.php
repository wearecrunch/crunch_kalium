<?php
/**
 *	Custom Column Params
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Custom column params
add_action('vc_after_init', 'lab_vc_custom_column_params');

function lab_vc_custom_column_params()
{
	$laborator_vc_dependency_reveal = array(
		'element' => 'reveal_effect',
		'not_empty' => true
	);
	
	$params = array(	
		# Reveal Effect
		'reveal_effect' => array(
			'type'        => 'dropdown',
			'heading'     => __( 'Reveal Effect', 'lab_composer' ),
			'param_name'  => 'reveal_effect',
			'std'         => 'none',
			'weight'	  => 3,
			'value'       => array(
				__('None','lab_composer')               => '',
				__('Fade In','lab_composer')            => 'fadeIn',
				__('Slide and Fade','lab_composer')     => 'fadeInLab',
				'---------------'                       => '',
				__("bounce", 'lab_composer')            => 'bounce',
				__("flash", 'lab_composer')             => 'flash',
				__("pulse", 'lab_composer')             => 'pulse',
				__("rubberBand", 'lab_composer')        => 'rubberBand',
				__("shake", 'lab_composer')             => 'shake',
				__("swing", 'lab_composer')             => 'swing',
				__("tada", 'lab_composer')              => 'tada',
				__("wobble", 'lab_composer')            => 'wobble',
				__("bounceIn", 'lab_composer')          => 'bounceIn',
				__("bounceInDown", 'lab_composer')      => 'bounceInDown',
				__("bounceInLeft", 'lab_composer')      => 'bounceInLeft',
				__("bounceInRight", 'lab_composer')     => 'bounceInRight',
				__("bounceInUp", 'lab_composer')        => 'bounceInUp',
				__("fadeInDown", 'lab_composer')        => 'fadeInDown',
				__("fadeInDownBig", 'lab_composer')     => 'fadeInDownBig',
				__("fadeInLeft", 'lab_composer')        => 'fadeInLeft',
				__("fadeInLeftBig", 'lab_composer')     => 'fadeInLeftBig',
				__("fadeInRight", 'lab_composer')       => 'fadeInRight',
				__("fadeInRightBig", 'lab_composer')    => 'fadeInRightBig',
				__("fadeInUp", 'lab_composer')          => 'fadeInUp',
				__("fadeInUpBig", 'lab_composer')       => 'fadeInUpBig',
				__("flip", 'lab_composer')              => 'flip',
				__("flipInX", 'lab_composer')           => 'flipInX',
				__("flipInY", 'lab_composer')           => 'flipInY',
				__("lightSpeedIn", 'lab_composer')      => 'lightSpeedIn',
				__("rotateIn", 'lab_composer')          => 'rotateIn',
				__("rotateInDownLeft", 'lab_composer')  => 'rotateInDownLeft',
				__("rotateInDownRight", 'lab_composer') => 'rotateInDownRight',
				__("rotateInUpLeft", 'lab_composer')    => 'rotateInUpLeft',
				__("rotateInUpRight", 'lab_composer')   => 'rotateInUpRight',
				__("hinge", 'lab_composer')             => 'hinge',
				__("rollIn", 'lab_composer')            => 'rollIn',
				__("zoomIn", 'lab_composer')            => 'zoomIn',
				__("zoomInDown", 'lab_composer')        => 'zoomInDown',
				__("zoomInLeft", 'lab_composer')        => 'zoomInLeft',
				__("zoomInRight", 'lab_composer')       => 'zoomInRight',
				__("zoomInUp", 'lab_composer')          => 'zoomInUp',

			),
			'description' => __( 'Set reveal effect for this element. To preview the animations <a href="http://daneden.github.io/animate.css/" target="_blank">click here</a>.', 'lab_composer' )
		),
			
		# Reveal Duration
		'reveal_duration' => array(
			'type'        => 'textfield',
			'heading'     => __('Reveal Duration', 'lab_composer'),
			'param_name'  => 'reveal_duration',
			'weight'	  => 2,
			'description' => __('Set number of seconds for the animation duration. (Optional)', 'lab_composer'),
			'dependency'  => $laborator_vc_dependency_reveal,
		),
			
		# Reveal Delay
		'reveal_delay' => array(
			'type'        => 'textfield',
			'heading'     => __('Reveal Delay', 'lab_composer'),
			'param_name'  => 'reveal_delay',
			'weight'	  => 1,
			'description' => __('Set reveal effect delay before showing in seconds, otherwise leave empty.', 'lab_composer'),
			'dependency'  => $laborator_vc_dependency_reveal
		),
	);
	
	
	vc_add_param('vc_column', $params['reveal_effect']);
	vc_add_param('vc_column', $params['reveal_duration']);
	vc_add_param('vc_column', $params['reveal_delay']);
}