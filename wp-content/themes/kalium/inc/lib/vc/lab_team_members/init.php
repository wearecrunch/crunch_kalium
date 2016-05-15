<?php
/**
 *	Team Members Shortcode
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'members.png';

# Team members (parent of Team member and team member placeholder)
vc_map( array(
	"base"                     => "lab_team_members",
	"name"                     => __("Team Members", "lab_composer"),
	"description"      		   => __("List your members", "lab_composer"),
	"category"                 => __('Laborator', 'lab_composer'),
	"content_element"          => true,
	"show_settings_on_create"  => true,
	"icon"                     => $lab_vc_element_icon,
	"as_parent"                => array('only' => 'lab_team_members_member,lab_team_members_placeholder'),
	"params"                   => array(
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Members per Row', 'lab_composer' ),
			'param_name'     => 'columns_count',
			'std'            => '3',
			'value'          => array(
				__('1 Member per Row','lab_composer')  => '1',
				__('2 Members per Row','lab_composer') => '2',
				__('3 Members per Row','lab_composer') => '3',
				__('4 Members per Row','lab_composer') => '4',
			),
			'description' => __( 'Set number of columns for team members.', 'lab_composer' )
		),
		$laborator_vc_general_params['reveal_effect_x'],
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
			'type'           => 'textfield',
			'heading'        => __( 'Image size', 'lab_composer' ),
			'param_name'     => 'img_size',
			'description'    => __( 'Enter image size. Example: Enter image size in pixels: 200x100 (Width x Height). Leave empty to use "460x460" size.', 'lab_composer' )
		),
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
	"base"             => "lab_team_members_member",
	"name"             => __("Team Member", "lab_composer"),
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
			'description'    => __( 'Add team member image here.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Name', 'lab_composer' ),
			'param_name'     => 'name',
			'admin_label'	 => true,
			'description'    => __( 'Name of the member.', 'lab_composer' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Sub Title', 'lab_composer' ),
			'param_name'     => 'sub_title',
			'description'    => __( 'Position or title of the member.', 'lab_composer' ),
		),
		array(
			'type'           => 'textarea_safe',
			'heading'        => __( 'Description', 'lab_composer' ),
			'param_name'     => 'description',
			'description'    => __( 'Include a small description for this member, this text area supports HTML too.', 'lab_composer' ),
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'Link', 'lab_composer' ),
			'param_name'     => 'link',
			'description'    => __( 'Make the name and thumbnail clickable (Optional).', 'lab_composer' ),
		),
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		)
	)
) );


# Team Member Placeholder (child of Team Members)
vc_map( array(
	"base"             => "lab_team_members_placeholder",
	"name"             => __("Placeholder", "lab_composer"),
	"description"      => __("Anonymous member", "lab_composer"),
	"category"         => __('Laborator', 'lab_composer'),
	"content_element"  => true,
	"icon"			   => $lab_vc_element_icon,
	"as_child"         => array('only' => 'lab_team_members'),
	"params"           => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Image Title', 'lab_composer' ),
			'param_name'     => 'image_title',
			'value'			 => 'your-image.jpg',
			'description'    => __( 'Add some text that will be paced after the image (Optional).', 'lab_composer' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Title', 'lab_composer' ),
			'param_name'     => 'title',
			'admin_label'	 => true,
			'value'			 => 'You Here',
			'description'    => __( 'Insert a sample title.', 'lab_composer' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Sub Title', 'lab_composer' ),
			'param_name'     => 'sub_title',
			'value'			 => 'Join us now!',
			'description'    => __( 'Insert a sample sub title (Optional).', 'lab_composer' ),
		),
		array(
			'type'           => 'vc_link',
			'heading'        => __( 'Sub Title Link', 'lab_composer' ),
			'param_name'     => 'link',
			'description'    => __( 'Make the name and thumbnail clickable (Optional).', 'lab_composer' ),
			'dependency' => array(
				'element' => 'sub_title',
				'not_empty' => true
			)
		),
		array(
			"type"           => "textfield",
			"heading"        => __("Extra class name", "lab_composer"),
			"param_name"     => "el_class",
			"description"    => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "lab_composer")
		)
	)
) );

class WPBakeryShortCode_Lab_Team_Members extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Lab_Team_Members_Member extends WPBakeryShortCode {}
class WPBakeryShortCode_Lab_Team_Members_Placeholder extends WPBakeryShortCode {}