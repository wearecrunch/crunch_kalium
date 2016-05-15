<?php
/**
 *	Laborator Social Networks
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url(str_replace(ABSPATH, '', $lab_vc_element_path));
$lab_vc_element_icon    = $lab_vc_element_url . 'social-networks.png';


vc_map( array(
	'base'             => 'lab_vc_social_networks',
	'name'             => __('Social Networks', 'lab_composer'),
	"description"      => __("Social network links", "lab_composer"),
	'category'         => __('Laborator', 'lab_composer'),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Display Type', 'lab_composer' ),
			'param_name' => 'display_type',
			'std'		 => 'no',
			'value'      => array(
				__('Rounded Icons','lab_composer')  => 'rounded-icons',
				__('Text Only','lab_composer')      => 'text-only',
				__('Icon + Text','lab_composer')    => 'icon-text',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
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

class WPBakeryShortCode_Lab_VC_Social_Networks extends WPBakeryShortCode {
	
	public function content($atts, $content = null)
	{
		# Atts
		$defaults = array(
			'display_type'   => '',
			'el_class'       => '',
			'css'            => ''
		);
		
		$atts = vc_shortcode_attribute_parse($defaults, $atts);
		
		extract( $atts );

		# Element Class
		$class = $this->getExtraClass( $el_class );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
		
		$css_class = "lab-vc-social-networks {$css_class}";
		
		$css_class .= " display-type-{$display_type}";

		ob_start();
		
		?>
		<div class="<?php echo esc_attr($css_class) . vc_shortcode_custom_css_class($css, ' '); ?>">
		<?php
			echo do_shortcode('[lab_social_networks]');
		?>
		</div>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
}
