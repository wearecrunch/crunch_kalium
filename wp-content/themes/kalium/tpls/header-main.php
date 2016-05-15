<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$nav = laborator_get_main_menu();

// Menu In Use
$menu_type = get_data( 'main_menu_type' );
$sticky_menu = get_data( 'header_sticky_menu' );

// Header Classes
$header_classes = array( 'main-header' );
$header_classes[] = "menu-type-" . esc_attr( $menu_type );

$header_options = array();

if ( $sticky_menu ) {
	$header_classes[] = 'is-sticky';
	$header_classes[] = 'sticky-soft-bg';
	
	$header_sticky_vpadding    = get_data( 'header_sticky_vpadding' );
	$header_sticky_bg          = get_data( 'header_sticky_bg' );
	$header_sticky_bg_alpha    = get_data( 'header_sticky_bg_alpha' );
	$header_sticky_mobile	   = get_data( 'header_sticky_mobile' );
	$header_sticky_autohide	   = get_data( 'header_sticky_autohide' );
	
	$sticky_immediate_activate = get_data( 'header_sticky_immediate' );
	
	$header_sticky_custom_logo     = get_data( 'header_sticky_custom_logo' );
	$header_sticky_logo_image_id   = get_data( 'header_sticky_logo_image_id' );
	$header_sticky_logo_width      = get_data( 'header_sticky_logo_width' );
	
	$header_sticky_menu_skin	   = get_data( 'header_sticky_menu_skin' );
	
	if ( $sticky_immediate_activate ) {
		$header_classes[] = 'sticky-immediate-activate';
	}
	
	if ( $header_sticky_autohide ) {
		$header_classes[] = 'sticky-autohide';
	}
	
	if ( is_numeric( $header_sticky_vpadding ) && $header_sticky_vpadding >= 0 ) {
		generate_custom_style( '.main-header.is-sticky.sticky-active', "padding-top: {$header_sticky_vpadding}px; padding-bottom: {$header_sticky_vpadding}px;", '', true );
	}
	
	if ( $header_sticky_bg ) {
		$hsbg_alpha = intval( $header_sticky_bg_alpha );
		$hsbg = labHex2Rgba( $header_sticky_bg, $hsbg_alpha/100 );
		
		generate_custom_style( '.main-header.is-sticky.sticky-active', "background-color: {$hsbg};", '', true );
	}
	
	if ( $header_sticky_custom_logo ) {
		$header_options['stickyUseCustomLogo'] = true;
		$header_options['stickyCustomLogo'] = str_replace( array( 'http:', 'https:' ), '', wp_get_attachment_image_src( $header_sticky_logo_image_id ? $header_sticky_logo_image_id : get_data( 'custom_logo_image' ), 'original' ) ); 
	}
	
	// Custom Width for the logo
	if( $header_sticky_logo_width ) {
		$header_options['stickyCustomLogoWidth'] = $header_sticky_logo_width;
	}
	
	if ( $header_sticky_menu_skin ) {
		$header_options['stickyMenuBarSkin'] = $header_sticky_menu_skin;
	}
	
	// Sticky menu disable on mobile
	if ( ! $header_sticky_mobile ) {
		$header_classes[] = 'sticky-mobile-disabled';
	}
}

?>
<header class="<?php echo implode( ' ', $header_classes ); ?>">
	<div class="container">

		<div class="logo-and-menu-container">
			
			<div class="logo-column">
				<?php get_template_part( 'tpls/logo' ); ?>
			</div>
				
			<div class="menu-column">
			<?php
			// Show Menu (by type)
			switch ( $menu_type ) :
			
				case 'full-bg-menu':
				
					$menu_full_bg_search_field      = get_data( 'menu_full_bg_search_field' );
					$menu_full_bg_submenu_indicator = get_data( 'menu_full_bg_submenu_indicator' );
					$menu_full_bg_alignment         = get_data( 'menu_full_bg_alignment' );
					$menu_full_bg_footer_block		= get_data( 'menu_full_bg_footer_block' );
					$menu_full_bg_skin				= get_data( 'menu_full_bg_skin' );
					
					$menu_bar_skin_active = $menu_full_bg_skin;
					
					switch ( $menu_full_bg_skin ) {
						case "menu-skin-light":
							$menu_bar_skin_active = 'menu-skin-dark';
							break;
							
						default:
							$menu_bar_skin_active = 'menu-skin-light';
					}
					?>
									
					<?php 
					// Cart Menu Icon
					if ( is_shop_supported() ) : 
						
						lab_wc_cart_menu_icon( $menu_full_bg_skin ); 
						
					endif; 	
					?>
					
					<a class="menu-bar <?php echo esc_attr( $menu_full_bg_skin ); ?>" data-menu-skin-default="<?php echo esc_attr( $menu_full_bg_skin ); ?>" data-menu-skin-active="<?php echo esc_attr( $menu_bar_skin_active ); ?>" href="#">
						<?php hamburger_menu_icon_or_label(); ?>
					</a>
					<?php
						break;
				
				case 'standard-menu':
					
					$menu_standard_menu_bar_visible    = get_data( 'menu_standard_menu_bar_visible' );
					$menu_standard_skin                = get_data( 'menu_standard_skin' );
					$menu_standard_menu_bar_effect     = get_data( 'menu_standard_menu_bar_effect' );
					
					?>
					<div class="standard-menu-container<?php 
						when_match( $menu_standard_menu_bar_visible, "menu-bar-root-items-hidden" );
						echo " {$menu_standard_skin}";
						echo " {$menu_standard_menu_bar_effect}";
					?>">
						
						<a class="menu-bar<?php 
							echo " {$menu_standard_skin}"; 
							when_match( $menu_standard_menu_bar_visible, '', 'hidden-md hidden-lg' );
						?>" href="#">
							<?php hamburger_menu_icon_or_label(); ?>
						</a>
						
						<?php 
						// Cart Menu Icon
						if ( is_shop_supported() ) : 
							
							lab_wc_cart_menu_icon( $menu_standard_skin );
							
						endif; 	
						?>
						
						<nav><?php echo $nav; // No escaping needed, this is wp_nav_menu() with echo=false ?></nav>
					</div>
					<?php
					break;
			
			case 'top-menu':
			
				$menu_top_skin = get_data( 'menu_top_skin' );
				?>
				
				<?php 
				// Cart Menu Icon
				if ( is_shop_supported() ) : 
					
					lab_wc_cart_menu_icon( $menu_top_skin ); 
					
				endif; 	
				?>
				
				<a class="menu-bar <?php echo esc_attr( $menu_top_skin ); ?>" href="#">
					<?php hamburger_menu_icon_or_label(); ?>
				</a>
				<?php
					break;
			
			case 'sidebar-menu':
				
				$menu_sidebar_skin = get_data( 'menu_sidebar_skin' );
				
				?>
				
				<?php 
				// Cart Menu Icon
				if ( is_shop_supported() ) : 
					
					lab_wc_cart_menu_icon( $menu_sidebar_skin ); 
					
				endif; 	
				?>
				
				<a class="menu-bar <?php echo esc_attr( $menu_sidebar_skin ); ?>" href="#">
					<?php hamburger_menu_icon_or_label(); ?>
				</a>
				<?php	
				
				endswitch;
				?>
			</div>
		</div>
		
		<?php
		// Full Screen Menu Container
		if ( $menu_type == 'full-bg-menu' ) :
		?>
		<div class="full-screen-menu menu-open-effect-fade<?php 
			echo " {$menu_full_bg_skin}";
			echo when_match( $menu_full_bg_submenu_indicator, 'submenu-indicator' );
			echo when_match( $menu_full_bg_alignment == 'centered-horizontal', 'menu-horizontally-center' );
			echo when_match( in_array( $menu_full_bg_alignment, array( 'centered', 'centered-horizontal' ) ), 'menu-aligned-center' );
			echo when_match( $menu_full_bg_footer_block, 'has-fullmenu-footer' );
		?>">
			<div class="container">
				<nav>
				<?php 
				echo $nav;
					
				if ( $menu_full_bg_search_field ) :
					
					?>
					<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" enctype="application/x-www-form-urlencoded">
						<input id="full-bg-search-inp" type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
						
						<label for="full-bg-search-inp">
							<?php 
								echo __( 'Search', 'kalium' );
								echo '<span><i></i><i></i><i></i></span>'; 
							?>
							</label>
						</form>
						<?php
						
					endif; 
					?>
					</nav>
				</div>
				
				<?php 
				if ( $menu_full_bg_footer_block ) : 
				?>
				<div class="full-menu-footer">
					<div class="container">
						<div class="right-part">
							<?php echo do_shortcode( '[lab_social_networks]' ); ?>
						</div>
						
						<div class="left-part">
							<?php echo do_shortcode( get_data( 'footer_text' ) ); ?>
						</div>
					</div>
				</div>
				<?php 
				endif; 
				?>
			</div>
		<?php
		endif;
		// End of: Full Screen Menu Container
		?>

	</div>
</header>

<script type="text/javascript">
	var headerOptions = <?php echo json_encode( $header_options ); ?>;
</script>
<?php

get_template_part( "tpls/page-heading-title" );
