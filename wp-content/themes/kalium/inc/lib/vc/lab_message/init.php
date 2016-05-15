<?php
/**
 *	Message Box
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'info.png';

/*
# Remove Existing VC Message, replace with the new one
add_action('vc_after_init', 'lab_remove_default_vc_message');

function lab_remove_default_vc_message()
{
	vc_remove_element('vc_message');
}
*/

vc_map( array(
	'base'             => 'lab_message',
	'name'             => __('Alert Box', 'lab_composer'),
	"description"      => __("Theme styled alerts", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Message Type', 'lab_composer' ),
			'param_name'     => 'type',
			'std'            => 'default',
			'admin_label'    => true,
			'value'          => array(
				__('Default', 'lab_composer')   => 'default',
				__('Info', 'lab_composer')      => 'info',
				__('Success', 'lab_composer')   => 'success',
				__('Warning', 'lab_composer')   => 'warning',
				__('Error', 'lab_composer')     => 'error',
			),
			'description' => __( 'Select the type of the alert message.', 'lab_composer' )
		),
		array(
			'type'           => 'textarea',
			'heading'        => __( 'Message', 'lab_composer' ),
			'param_name'     => 'message',
			'description'    => __( 'Enter your message to display in the dialogue, you can include HTML tags too.', 'lab_composer' )
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Close Button', 'lab_composer' ),
			'param_name' => 'close_button',
			'value' => array(
				__( 'Allow user to dismiss the alert (X - icon)', 'lab_composer' ) => 'yes',
			)
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

class WPBakeryShortCode_Lab_Message extends WPBakeryShortCode {}