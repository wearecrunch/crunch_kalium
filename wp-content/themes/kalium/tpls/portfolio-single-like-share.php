<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

if ( ! $portfolio_share_item && ! $portfolio_likes ) {
	return;
}

$portfolio_like_share_layout = get_data( 'portfolio_like_share_layout' );


# Default Layout
if ( $portfolio_like_share_layout == 'default' ) :

/*
	if ( ! $portfolio_share_item && ! $portfolio_likes ) {
		return;
	}
*/

	?>
	<div class="social social-links-plain">

		<?php if ( $portfolio_likes ) : $likes = get_post_likes(); ?>
		<div class="likes">
			<a href="#" class="like-btn" data-id="<?php echo get_the_id(); ?>">
				<i class="icon fa <?php echo $likes['liked'] ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
				<span class="counter like-count"><?php echo esc_html( $likes['count'] ); ?></span>
			</a>
		</div>
		<?php endif; ?>

		<?php if ( $portfolio_share_item ) : ?>
		<div class="share-social">
			<h4><?php _e( 'Share', 'kalium' ); ?></h4>
			<div class="social-links">
				<?php
				foreach ( $portfolio_share_item_networks['visible'] as $network_id => $network ) :

					if ( $network_id == 'placebo' ) {
						continue;
					}

					share_story_network_link( $network_id, $id );

				endforeach;
				?>
			</div>
		</div>
		<?php endif; ?>

	</div>
	<?php

endif;

# Rounded Buttons
if ( $portfolio_like_share_layout == 'rounded' ) :

	?>
	<div class="social-buttons social">

		<div class="social-links">
			<?php if ( $portfolio_likes ) : $likes = get_post_likes(); ?>
			<a href="#" class="social-share-icon like-btn<?php echo $likes['liked'] ? ' is-liked' : ''; ?>" data-id="<?php the_ID(); ?>">
				<i class="icon fa fa-heart<?php echo $likes['liked'] ? '' : '-o'; ?>"></i>
				<span class="like-count"><?php echo esc_html( $likes['count'] ); ?></span>
			</a>
			<?php endif; ?>

			<?php
			if ( $portfolio_share_item ) :

				foreach ( $portfolio_share_item_networks['visible'] as $network_id => $network ) :

					if ( $network_id == 'placebo' ) {
						continue;
					}

					share_story_network_link( $network_id, $id, 'social-share-icon', true );

				endforeach;

			endif;
			?>
		</div>

	</div>
	<?php

endif;
