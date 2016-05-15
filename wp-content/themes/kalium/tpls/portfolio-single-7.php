<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

include locate_template( 'tpls/portfolio-details.php' );
?>

<div class="vc-container portfolio-vc-type-container">
	<?php the_content(); ?>
</div>

<div class="container">

	<div class="page-container">

		<div class="single-portfolio-holder portfolio-type-7 clearfix">
			
			<?php include locate_template( 'tpls/portfolio-single-prevnext.php' ); ?>
			
		</div>
	
	</div>
	
</div>