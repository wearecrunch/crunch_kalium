<?php
/**
 *	Client Logos Shortcode
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'clients.png';

# Clients (parent of client entry)
vc_map( array(
	"base"                     => "lab_clients",
	"name"                     => __("Clients", "lab_composer"),
	"description"      		   => __("Partners/clients logos", "lab_composer"),
	"category"                 => __('Laborator', 'lab_composer'),
	"content_element"          => true,
	"show_settings_on_create"  => true,
	"icon"                     => $lab_vc_element_icon,
	"as_parent"                => array('only' => 'lab_clients_entry'),
	"params"                   => array(
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Clients per Row', 'lab_composer' ),
			'param_name'     => 'columns_count',
			'std'            => '4',
			'value'          => array(
				__('2 Logos per Row','lab_composer')    => '2',
				__('3 Logos per Row','lab_composer')    => '3',
				__('4 Logos per Row','lab_composer')    => '4',
				__('6 Logos per Row','lab_composer')    => '6',
				__('12 Logos per Row','lab_composer')   => '12',
			),
			'description' => __( 'Set number of columns for clients/partners logos.', 'lab_composer' )
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Spacing', 'lab_composer' ),
			'param_name' => 'column_spacing',
			'std'		 => 'no',
			'value'      => array(
				__('No spacing','lab_composer')             => 'no',
				__('Apply default spacing','lab_composer')  => 'yes',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Image Borders', 'lab_composer' ),
			'param_name' => 'image_borders',
			'std'		 => 'yes',
			'value'      => array(
				__('No','lab_composer')     => 'no',
				__('Yes','lab_composer')    => 'yes',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Hover Style', 'lab_composer' ),
			'param_name' => 'hover_style',
			'std'		 => 'full',
			'value'      => array(
				__('None','lab_composer')                       => 'none',
				__('Full background hover','lab_composer')      => 'full',
				__('Distanced background hover','lab_composer') => 'distanced',
			),
			'description' => __( 'Select hover effect style to apply for team members entries.', 'lab_composer' )
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Custom Hover Color', 'lab_composer' ),
			'param_name'     => 'hover_bg',
			'description'    => __( 'You can set custom hover color.', 'lab_composer' ),
			'dependency'     => array(
				'element'=> 'hover_style',
				'value' => array('full' ,'distanced')
			),
		),
		array(
			'type'           => 'colorpicker',
			'heading'        => __( 'Custom Hover Text Color', 'lab_composer' ),
			'param_name'     => 'hover_txt',
			'description'    => __( 'You can set custom hover text color.', 'lab_composer' ),
			'dependency'     => array(
				'element'=> 'hover_style',
				'value' => array('full' ,'distanced')
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Image size', 'lab_composer' ),
			'param_name'     => 'img_size',
			'description'    => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Minimum Height', 'lab_composer' ),
			'param_name'     => 'height',
			'description'    => __( 'You can alternatively enter height of the logo entries. If empty it will use the highest height of logos.', 'lab_composer' )
		),
		$laborator_vc_general_params['reveal_effect_x'],
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		)
	),
	"js_view" => 'VcColumnView'
) );


# Team Member (child of Team Members)
vc_map( array(
	"base"             => "lab_clients_entry",
	"name"             => __("Client Logo", "lab_composer"),
	"description"      => __("Member details", "lab_composer"),
	"category"         => __('Laborator', 'lab_composer'),
	"content_element"  => true,
	"icon"			   => $lab_vc_element_icon,
	"as_child"         => array('only' => 'lab_team_members'),
	"params"           => array(
		array(
			'type'           => 'attach_image',
			'heading'        => __( 'Image', 'lab_composer' ),
			'param_name'     => 'image',
			'value'          => '',
			'description'    => __( 'Add logo image here.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'	 => true,
			'description'    => __( 'Title of the client/partner (shown on hover).', 'lab_composer' ),
		),
		array(
			'type'           => 'textarea',
			'heading'        => __( 'Description', 'lab_composer' ),
			'param_name'     => 'description',
			'description'    => __( 'Small description about the client/partner, this text area supports HTML too (shown on hover).', 'lab_composer' ),
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'Link', 'lab_composer' ),
			'param_name'     => 'link',
			'description'    => __( 'Add custom for this logo (Optional).', 'lab_composer' ),
		),
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		)
	)
) );


class WPBakeryShortCode_Lab_Clients extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Lab_Clients_Entry extends WPBakeryShortCode {}