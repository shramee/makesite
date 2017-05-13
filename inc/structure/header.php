<?php
/**
 * Header functions
 * @action makesite_header
 * @since 1.0.0
 *
 * @developer shramee.me <me@shramee.me>
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
		makesite_skiplinks();
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
			<?php
			if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				makesite_hd_title();
				makesite_hd_description();
			}
			?>
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

if ( ! function_exists( 'makesite_hd_top_nav' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_top_nav() {
		makesite_do_action(
			'header_top_nav',
			array(
				'tag'    => 'nav',
				'attrs'  => array(
					'id'    => 'top-navigation',
					'class' => "top-menu s-hide",
				),
				'before' => '<div class="container">',
				'after'  => '</div><!-- .container -->',
			)
		);
	}
endif;

if ( ! function_exists( 'makesite_hd_right_nav' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_right_nav() {
		makesite_do_action(
			'header_right_nav',
			array(
				'tag'    => 'nav',
				'attrs'  => array(
					'id'    => 'right-header-navigation',
					'class' => "right-header-menu s-hide",
				),
				'before' => '<div class="container">',
				'after'  => '</div><!-- .container -->',
			)
		);
	}
endif;

if ( ! function_exists( 'makesite_hd_left_nav' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_left_nav() {
		makesite_do_action(
			'header_left_nav',
			array(
				'tag'    => 'nav',
				'attrs'  => array(
					'id'    => 'left-header-navigation',
					'class' => "left-header-menu s-hide",
				),
				'before' => '<div class="container">',
				'after'  => '</div><!-- .container -->',
			)
		);
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

		$menu_action_args = array(
			'tag'    => 'div',
			'attrs'  => array(
				'class' => "desktop-menu s-hide",
			),
			'before' => $fw_ct,
			'after'  => $fw_ct_close,
		);

		makesite_do_action(
			'header_desktop_nav',
			$menu_action_args
		);

		$menu_action_args['attrs']['class'] = "mobile-menu m-hide l-hide";
		makesite_do_action(
			'header_mobile_nav',
			$menu_action_args
		);

		echo "</nav><!-- #site-navigation -->$fw_ct";
	}
endif;

if ( ! function_exists( 'makesite_desktop_nav' ) ) :
	/**
	 * Outputs desktop nav
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_desktop_nav() {
		if ( apply_filters( 'makesite_show_desktop_menu', has_nav_menu( 'primary-desktop-menu' ) ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary-desktop-menu',
					'menu_id'        => 'desktop-menu',
					'menu_class'     => 'nav-horizontal menu-primary',
				)
			);
		} elseif ( current_user_can( 'edit_theme_options' ) ) {
			$url = admin_url( 'nav-menus.php' );
			echo "<a href='$url'>Click here to assign desktop menu.</a>";
		}
	}
endif;

if ( ! function_exists( 'makesite_mobile_nav_btn' ) ) :
	/**
	 * Outputs mobile nav toggle button
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_mobile_nav_btn() {
		if ( apply_filters( 'makesite_show_mobile_menu', has_nav_menu( 'primary-mobile-menu' ) ) ) {
			?>
			<a class="menu-toggle"><i class="icon-bars"></i> <?php _x( 'Menu', 'menu-toggle-button', 'makesite' ) ?></a>
			<?php
		} elseif ( current_user_can( 'edit_theme_options' ) ) {
			$url = admin_url( 'nav-menus.php' );
			$assign_menu_label = __( 'Assign mobile menu.', 'makesite' );
			echo "<a href='$url'>$assign_menu_label</a>";
		}
	}
endif;

if ( ! function_exists( 'makesite_mobile_nav' ) ) :
	/**
	 * Outputs mobile nav
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_mobile_nav() {
		if ( apply_filters( 'makesite_show_mobile_menu', has_nav_menu( 'primary-mobile-menu' ) ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary-mobile-menu',
				'menu_id'        => 'mobile-menu',
				'menu_class'     => 'menu-mobile',
			) );
		}
	}
endif;
