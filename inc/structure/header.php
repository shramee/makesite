<?php
/**
 * Header functions
 * @action makesite_header
 * @since 1.0.0
 *
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 *
 * @package makesite
 */

if ( ! function_exists( 'makesite_hd_skiplinks' ) ) :
	/**
	 * Outputs skip links in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_skiplinks() {
		?>
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'makesite' ); ?></a>
		<?php
	}
endif;

if ( ! function_exists( 'makesite_hd_branding' ) ) :
	/**
	 * Outputs site branding in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_branding() {
		?>
		<div class="site-branding">
			<?php makesite_hd_title(); ?>
			<?php makesite_hd_description(); ?>
		</div><!-- .site-branding -->
		<?php
	}
endif;

if ( ! function_exists( 'makesite_hd_title' ) ) :
	/**
	 * Outputs title for site branding
	 * @since 1.0.0
	 */
	function makesite_hd_title() {
		?>
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>
		<?php
	}
endif;

if ( ! function_exists( 'makesite_hd_description' ) ) :
	/**
	 * Outputs description for site branding
	 * @since 1.0.0
	 */
	function makesite_hd_description() {
		$description = get_bloginfo( 'description', 'display' );
		if ( $description ) : ?>
			<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'makesite_hd_navigation' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_navigation() {
		$fw_ct = $fw_ct_close = '';

		/**
		 * @filter makesite_hd_full_width_navigation
		 * Make the navigation span full width
		 */
		if ( apply_filters( 'makesite_hd_full_width_navigation', true ) ) {
			$fw_ct       = '<div class="container">';
			$fw_ct_close = '</div><!-- .container -->';
		}

		echo "$fw_ct_close<nav id='site-navigation' class='main-navigation' role='navigation'>";

		ms_do_action(
			'header_desktop_nav',
			array(
				'tag'    => 'div',
				'attrs'  => array(
					'class' => "desktop-menu s-hide",
				),
				'before' => $fw_ct,
				'after'  => $fw_ct_close,
			)
		);

		ms_do_action(
			'header_mobile_nav',
			array(
				'tag'    => 'div',
				'attrs'  => array(
					'class' => "mobile-menu m-hide l-hide",
				),
				'before' => $fw_ct,
				'after'  => $fw_ct_close,
			)
		);

		echo "</nav><!-- #site-navigation -->$fw_ct";
	}
endif;

if ( ! function_exists( 'makesite_desktop_nav' ) ) :
	/**
	 * Outputs skip links in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_desktop_nav() {
		wp_nav_menu(
			array(
				'theme_location' => 'primary-desktop',
				'menu_id' => 'desktop-menu',
				'menu_class' => 'nav-horizontal menu-primary'
			)
		);
	}
endif;

if ( ! function_exists( 'makesite_mobile_nav_btn' ) ) :
	/**
	 * Outputs skip links in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_mobile_nav_btn() {
		?>
		<a class="menu-toggle"><i class="fa fa-bars"></i>Menu</a>
		<?php
	}
endif;

if ( ! function_exists( 'makesite_mobile_nav' ) ) :
	/**
	 * Outputs skip links in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_mobile_nav() {
		wp_nav_menu( array( 'theme_location' => 'primary-mobile', 'menu_id' => 'mobile-menu' ) );
	}
endif;
