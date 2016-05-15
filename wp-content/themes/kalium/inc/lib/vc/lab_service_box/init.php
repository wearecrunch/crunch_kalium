<?php
/**
 *	Featured Tab
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'services.png';

# Service Box (parent of icon box content and vc icon)
vc_map( array(
	"base"                     => "lab_service_box",
	"name"                     => __("Service Box", "lab_composer"),
	"description"    		   => __("Description with icon", "lab_composer"),
	"category"                 => __('Laborator', 'lab_composer'),
	"content_element"          => true,
	"show_settings_on_create"  => false,
	"icon"                     => $lab_vc_element_icon,
	"as_parent"                => array('only' => 'vc_icon,lab_service_box_content'),
	"params"                   => array(
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		),
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'lab_composer' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'lab_composer' ),
        ),
	),
	"js_view" => 'VcColumnView'
) );


# Box Content (child of Service Box)
vc_map( array(
	"base"             => "lab_service_box_content",
	"name"             => __("Service Content", "lab_composer"),
	"description"      => __("Describe your service", "lab_composer"),
	"category"         => __('Laborator', 'lab_composer'),
	"content_element"  => true,
	"icon"			   => $lab_vc_element_icon,
	"as_child"         => array('only' => 'lab_service_box'),
	"params"           => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'	 => true,
			'description'    => __( 'Title of the widget.', 'lab_composer' ),
		),
		array(
			'type'           => 'textarea',
			'heading'        => __( 'Description', 'lab_composer' ),
			'param_name'     => 'description',
			'description'    => __( 'Description about the service or the item you provide.', 'lab_composer' ),
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Text Alignment', 'lab_composer' ),
			'param_name'     => 'text_alignment',
			'std'            => 'left',
			'value'          => array(
				__('Left', 'lab_composer')      => 'left',
				__('Center', 'lab_composer')    => 'center',
				__('Right', 'lab_composer')     => 'right',
			),
			'description' => __( 'Set number of columns for team members.', 'lab_composer' )
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'Link', 'lab_composer' ),
			'param_name'     => 'link',
			'description'    => __( 'Make the title clickable (Optional).', 'lab_composer' ),
		),
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		),
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'lab_composer' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'lab_composer' ),
        ),
	)
) );


class WPBakeryShortCode_Lab_Service_Box extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Lab_Service_Box_Content extends WPBakeryShortCode {}