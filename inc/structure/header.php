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
		$skip2contnt = esc_html__( 'Skip to content', 'makesite' )
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
		$fw_cntnr = $fw_cntnr_close = '';

		if ( $full_width = apply_filters( 'makesite_hd_full_width_navigation', true ) ) {
			$fw_cntnr       = '<div class="col-full">';
			$fw_cntnr_close = '</div><!-- .col-full -->';
		}

		if ( has_nav_menu( 'primary-desktop' ) ) :
			ms_do_action(
				'header_navs',
				"$fw_cntnr_close<nav id=\"site-navigation\" class=\"main-navigation\" role=\"navigation\">",
				"</nav><!-- #site-navigation -->$fw_cntnr",
				array( $full_width )
			);
		endif; //wp_nav_menu primary-desktop
	}
endif;

if ( ! function_exists( 'makesite_hd_navs' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_navs( $full_width = true ) {
		$fw_ct = $fw_ct_close = '';

		if ( $full_width ) {
			$fw_ct       = '<div class="col-full">';
			$fw_ct_close = '</div><!-- .col-full -->';
		}

		if ( has_nav_menu( 'primary-desktop' ) ) :
			ms_do_action(
				'header_desktop_nav',
				"<div class='desktop-menu s-hide'>$fw_ct",
				"$fw_ct_close</div><!-- .desktop-menu -->"
			);
		endif; //wp_nav_menu primary-desktop

		if ( has_nav_menu( 'primary-mobile' ) ) :
			ms_do_action(
				'header_mobile_nav',
				"$fw_ct<div class='mobile-menu m-hide l-hide'>",
				"</div><!-- .desktop-menu -->$fw_ct_close"
			);
		endif; //wp_nav_menu primary-mobile
	}
endif;


if ( ! function_exists( 'makesite_desktop_nav' ) ) :
	/**
	 * Outputs skip links in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_desktop_nav() {
		wp_nav_menu( array( 'theme_location' => 'primary-desktop', 'menu_id' => 'desktop-menu' ) );
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
