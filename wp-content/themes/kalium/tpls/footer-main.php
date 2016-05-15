<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$footer_fixed		= get_data( 'footer_fixed' );

$footer_style       = get_data( 'footer_style' );
$footer_bg          = get_data( 'footer_bg' );

$footer_text        = get_data( 'footer_text' );
$footer_text_right  = get_data( 'footer_text_right' );

$footer_bottom_style = get_data('footer_bottom_style');

if ( $footer_bg ) {
	$footer_bg = esc_attr( $footer_bg );
	echo compress_text( "<style> footer.main-footer { background-color: {$footer_bg}; } </style>" );
}

$footer_classes = array( 'main-footer', 'footer-bottom-' . esc_attr( $footer_bottom_style ) );

if ( $footer_fixed ) {
	$footer_classes[] = 'fixed-footer';
	
	if ( $footer_fixed == 'fixed-fade' ) {
		$footer_classes[] = 'fixed-footer-fade';
	}
	else if ( $footer_fixed == 'fixed-slide' ) {
		$footer_classes[] = 'fixed-footer-slide';
	}
}

if ( $footer_style ) {
	$footer_classes[] = 'main-footer-' . esc_attr( $footer_style );
}

?>
<footer id="footer" class="<?php echo implode( ' ', $footer_classes ); ?>">
	<div class="container">
		<?php get_template_part( 'tpls/footer-widgets' ); ?>
	</div>

	<?php if ( get_data( 'footer_bottom_visible' ) ) : ?>
	<div class="footer-bottom">
		<div class="container">

			<div class="footer-links">
				<div class="row">
					<?php if ( $footer_text_right ) : ?>
					<div class="col-sm-7 right-side pull-right-sm">
						<?php echo lab_esc_script( do_shortcode( $footer_text_right ) ); ?>
					</div>
					<?php endif; ?>

					<?php if ( $footer_text ) : ?>
					<div class="<?php echo $footer_text_right ? 'col-sm-5' : 'col-xs-12'; ?>">
						<div class="copyright">
							<p><?php echo lab_esc_script( do_shortcode( $footer_text ) ); ?></p>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
	<?php endif; ?>

</footer>