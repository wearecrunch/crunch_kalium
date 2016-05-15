<?php
/**
 *	Portable Contact Form
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Element Information
$lab_vc_element_path    = dirname( __FILE__ ) . '/';
$lab_vc_element_url     = site_url( str_replace( ABSPATH, '', $lab_vc_element_path ) );
$lab_vc_element_icon    = $lab_vc_element_url . 'contact.png';


vc_map( array(
	'base'             => 'lab_contact_form',
	'name'             => __( 'Contact Form', 'lab_composer' ),
	"description"      => __("Insert AJAX form", "lab_composer"),
	'category'         => __( 'Laborator', 'lab_composer' ),
	'icon'             => $lab_vc_element_icon,
	'params' => array(
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Name Title', 'lab_composer' ),
			'param_name'     => 'name_title',
			'value'          => 'Name:'
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Email Title', 'lab_composer' ),
			'param_name'     => 'email_title',
			'value'          => 'Email:'
		),
		array(
			'type'       => 'textfield',
			'heading'    => __( 'Subject Title', 'lab_composer' ),
			'param_name' => 'subject_title',
			'value'      => 'Subject:',
			'dependency' => array(
				'element'   => 'show_subject_field',
				'value'     => array('yes')
			),
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Message Title', 'lab_composer' ),
			'param_name'     => 'message_title',
			'value'          => 'Message:'
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Subject Field', 'lab_composer' ),
			'param_name'     => 'show_subject_field',
			'std'            => 'no',
			'value'          => array(
				__( 'Show subject field', 'lab_composer') => 'yes',
			),
			'description' => __( 'Set spacing for logo columns.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Submit Title', 'lab_composer' ),
			'param_name'     => 'submit_title',
			'value'          => 'Send Message'
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Success Message', 'lab_composer' ),
			'param_name'     => 'submit_success',
			'value'          => 'Thank you #, message sent!'
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Show Error Alerts', 'lab_composer' ),
			'param_name'     => 'alert_errors',
			'std'            => 'no',
			'value'          => array(
				__( 'Yes', 'lab_composer') => 'yes',
			),
			'description' => __( 'Show JavaScript alert message when required field is not filled.', 'lab_composer' )
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Receiver', 'lab_composer' ),
			'description'	 => 'Enter an email to receive contact form messages. If empty default admin email will be used ('.get_option('admin_email').')',
			'param_name'     => 'email_receiver'
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

class WPBakeryShortCode_Lab_Contact_Form extends WPBakeryShortCode {}




# Contact Form Processing
add_action( 'wp_ajax_lab_contact_form_request', 'lab_contact_form_request' );
add_action( 'wp_ajax_nopriv_lab_contact_form_request', 'lab_contact_form_request' );

function lab_contact_form_request() {
	$resp = array(
		'success' => false
	);
	
	$id        = post( 'id' );
	$check     = post( 'check' );
	$name      = post( 'name' );
	$email     = post( 'email' );
	$subject   = post( 'subject' );
	$message   = post( 'message' );
	
	$details   = post( 'request' );
	$details   = ( array ) json_decode( base64_decode( str_rot13( $details ) ) );
	
	$nonce_id = "cf_" . md5( $id . json_encode( $details ) );
	
	if ( apply_filters( 'lab_contact_form_skip_verification', false ) || wp_verify_nonce( $check, $nonce_id )/*  && is_email($email) */) {
		$resp['success'] = true;
		
		$email_receiver = $details['email_receiver'];
		
		if ( ! is_email( $email_receiver ) ) {
			$email_receiver = get_option('admin_email');
		}
		
		# Message Body
		$details['name_title']    .= strpos( $details['name_title'], ':' ) == -1 ? ': ' : '';
		$details['email_title']   .= strpos( $details['email_title'], ':' ) == -1 ? ': ' : '';
		$details['subject_title'] .= strpos( $details['subject_title'], ':' ) == -1 ? ': ' : '';
		$details['message_title'] .= strpos( $details['message_title'], ':' ) == -1 ? ': ' : '';
		
		
		$message_body  = "You have received new contact form message.\n\n----- Message Details -----\n\n";
		$message_body .= "{$details['name_title']} {$name}\n\n";
		$message_body .= "{$details['email_title']} {$email}\n\n";
		
		if ( $details['show_subject_field'] == 'yes' ) {
			if ($subject ) {
				$message_body .= "{$details['subject_title']} {$subject}\n\n";
			}
		}
		
		$message_body .= "{$details['message_title']}\n\n{$message}\n\n";
		$message_body .= "--\n\nThis message has been sent from IP: {$_SERVER['REMOTE_ADDR']}\n\nURL: " . home_url();
		
		$subject      = apply_filters( 'kalium_contact_form_subject', "[" . get_bloginfo( 'name' ) . "] New Contact Form Message has been received.", $details );
		$message_body = apply_filters( 'kalium_contact_form_message_body', $message_body, $details );
		
		$headers = array();
		$headers[] = "Reply-To: {$name} <{$email}>";
		
		wp_mail( $email_receiver, $subject, $message_body, $headers );
	}
	
	echo json_encode( $resp );
	die();
}