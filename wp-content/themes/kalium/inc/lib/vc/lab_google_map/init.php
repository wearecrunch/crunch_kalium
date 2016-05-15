<?php
/**
 *	Google Map
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url( str_replace( ABSPATH, '', $lab_vc_element_path ) );
$lab_vc_element_icon    = $lab_vc_element_url . 'map.png';

add_action( 'wp_enqueue_scripts', 'lab_vc_google_map_enqueue' );

function lab_vc_google_map_enqueue() {
	$lab_vc_element_path   = dirname( __FILE__ ) . '/';
	$lab_vc_element_url    = site_url( str_replace( ABSPATH, '', $lab_vc_element_path ) );

	wp_register_script( 'lab-vc-google-maps', THEMEURL . 'inc/lib/vc/lab_google_map/maps.js' );
}


vc_map( array(
	'base'                     => 'lab_google_map',
	'name'                     => __('Map', 'lab_composer'),
	"description"              => __("Insert Google Map", "lab_composer"),
	'category'                 => __('Laborator', 'lab_composer'),
	"content_element"          => true,
	"show_settings_on_create"  => true,
	'icon'                     => $lab_vc_element_icon,
	"as_parent"                => array('only' => 'lab_google_map_location'),
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Map Height', 'lab_composer' ),
			'param_name'     => 'height',
			'value'			 => '400',
			'description'    => __( 'Set map container height.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Map Zoom', 'lab_composer' ),
			'param_name'     => 'zoom',
			'value'			 => '14',
			'description'    => __( 'Set map zoom level. Leave 0 to automatically fit to bounds.', 'lab_composer' )
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Map Toggles', 'lab_composer' ),
			'param_name'     => 'map_options',
			'std'            => 'map-style,scroll-zoom,drop-pins',
			'value'          => array(
				__('Full width<br />', 'lab_composer') => 'fullwidth',
				__('Pan by<br />', 'lab_composer') => 'pan-by',
				__('Map Style<br />', 'lab_composer') => 'map-style',
				__('Scroll Zoom<br />', 'lab_composer') => 'scroll-zoom',
				__('Dropping Pins Animation', 'lab_composer') => 'drop-pins',
			),
			'description'    => __( 'Toggle map options.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Pan-by Params', 'lab_composer' ),
			'param_name'     => 'map_panby',
			'description'    => __( 'Enter panBy params: x:number, y:number. Example: <strong>50,25</strong> or <strong>50</strong> to move just X-axis', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'map_options',
				'value'     => array('pan-by')
			),
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Map Controls', 'lab_composer' ),
			'param_name'     => 'map_controls',
			'std'            => 'panControl,zoomControl,mapTypeControl,scaleControl',
			'value'          => array(
				__('Pan Control<br />', 'lab_composer')             => 'panControl',
				__('Zoom Control<br />', 'lab_composer')            => 'zoomControl',
				__('Map Type Control<br />', 'lab_composer')        => 'mapTypeControl',
				__('Scale Control<br />', 'lab_composer')           => 'scaleControl',
				__('Street View Control<br />', 'lab_composer')     => 'streetViewControl',
				__('Overview Map Control<br />', 'lab_composer')    => 'overviewMapControl',
				__('Plus Minus Zoom<br />', 'lab_composer')    		=> 'plusMinusZoom',
			),
			'description'    => __( 'Toggle map options.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Map Type', 'lab_composer' ),
			'param_name'     => 'map_type',
			'std'            => 'roadmap',
			'value'          => array(
				__('Roadmap', 'lab_composer')   => 'roadmap',
				__('Satellite', 'lab_composer') => 'satellite',
				__('Hybrid', 'lab_composer')    => 'hybrid',
			),
			'description' => __( 'Choose map style.', 'lab_composer' )
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Map Tilt', 'lab_composer' ),
			'param_name'     => 'map_tilt',
			'std'            => '0',
			'value'          => array(
				__('Normal', 'lab_composer')   => '0',
				__('Tilt 45°', 'lab_composer') => '45',
			),
			'description' => __( 'This map type supports 45&deg; map tilt.', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'map_type',
				'value'     => array('satellite', 'hybrid')
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Map Heading', 'lab_composer' ),
			'param_name'     => 'map_heading',
			'description'    => __( 'Set the degree of rotation (0-360) for map tilt.', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'map_tilt',
				'value'     => array('45')
			),
		),
		array(
			'type' => 'textarea_raw_html',
			#'holder' => 'div',
			'heading' => __( 'Map Style', 'lab_composer' ),
			'param_name' => 'map_style',
			'value' => '',
			'description' => __( 'Paste the style code here. Browse map styles in <a href="https://snazzymaps.com/" target="_blank">SnazzyMaps</a>', 'lab_composer' )
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
	),
	"js_view" => 'VcColumnView'
) );

# Map Location (child of Google Map)
vc_map( array(
	"base"             => "lab_google_map_location",
	"name"             => __("Map Location", "lab_composer"),
	"description"      => __("Add map marker", "lab_composer"),
	"category"         => __('Laborator', 'lab_composer'),
	"content_element"  => true,
	"icon"			   => $lab_vc_element_icon,
	"as_child"         => array('only' => 'lab_google_map'),
	"params"           => array(
		array(
			'type'           => 'attach_image',
			'heading'        => __( 'Marker Image', 'lab_composer' ),
			'param_name'     => 'marker_image',
			'value'          => '',
			'description'    => __( 'Add your Custom marker image or use default one.', 'lab_composer' )
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Retina Marker', 'lab_composer' ),
			'param_name'     => 'retina_marker',
			'std'            => '',
			'value'          => array(
				__('Yes', 'lab_composer') => 'yes',
			),
			'description'    => __( 'Enabling this option will reduce the size of marker for 50%, example if marker is 32x32 it will be 16x16.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Latitude', 'lab_composer' ),
			'admin_label' 	 => true,
			'param_name'     => 'latitude',
			'value'			 => '',
			'description'    => __( 'Enter latitude coordinate. To select map coordinates <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">click here</a>.', 'lab_composer' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Longitude', 'lab_composer' ),
			'admin_label' 	 => true,
			'param_name'     => 'longitude',
			'value'			 => '',
			'description'    => __( 'Enter longitude coordinate.', 'lab_composer' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Marker Title', 'lab_composer' ),
			'admin_label' 	 => true,
			'param_name'     => 'marker_title',
			'value'			 => '',
		),
		array(
			'type'           => 'textarea_safe',
			'heading'        => __( 'Marker Description', 'lab_composer' ),
			'param_name'     => 'marker_description',
			'value'			 => '',
		)
	)
) );

class WPBakeryShortCode_Lab_Google_Map extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_Lab_Google_Map_Location extends WPBakeryShortCode {}