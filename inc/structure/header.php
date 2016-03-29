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

if ( ! function_exists( 'makesite_hd_open' ) ) :
	/**
	 * Opens the header container
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_open() {
		?>
		<header id="masthead" class="site-header" role="banner">
		<div class="col-full">
		<?php
	}
endif;

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
	$full_width = apply_filters( 'makesite_hd_full_width_navigation', true );
		if ( $full_width ) {
			?>
			</div><!-- .col-full -->
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php makesite_hd_nav_menus( $full_width ) ?>
			</nav><!-- #site-navigation -->
			<div class="col-full">
		<?php
		} else {
		?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php makesite_hd_nav_menus( $full_width ) ?>
			</nav><!-- #site-navigation -->
			<?php
		}
	}
endif;

if ( ! function_exists( 'makesite_hd_nav_menus' ) ) :
	/**
	 * Outputs navigation menu in header
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_nav_menus( $full_width = true ) {
		if ( has_nav_menu( 'primary-desktop' ) ) :
			?>
			<div class="desktop-menu s-hide">
				<?php
				if ( $full_width ) { ?>
					<div class="col-full">
						<?php wp_nav_menu( array( 'theme_location' => 'primary-desktop', 'menu_id' => 'desktop-menu' ) ); ?>
					</div><!-- .col-full -->
					<?php
				} else {
					wp_nav_menu( array( 'theme_location' => 'primary-desktop', 'menu_id' => 'desktop-menu' ) );
				}
				?>
			</div>
			<?php
		endif; //wp_nav_menu primary-desktop
		if ( has_nav_menu( 'primary-mobile' ) ) :
			if ( $full_width ) {
				?>
				<div class="col-full">
					<div class="mobile-menu m-hide l-hide">
						<div class="menu-toggle"><i class="fa fa-bars"></i>Menu</div>
						<?php wp_nav_menu( array( 'theme_location' => 'primary-mobile', 'menu_id' => 'mobile-menu' ) ); ?>
					</div>
				</div><!-- .col-full -->
				<?php
			} else {
				?>
				<div class="mobile-menu m-hide l-hide">
					<div class="menu-toggle"><i class="fa fa-bars"></i>Menu</div>
					<?php wp_nav_menu( array( 'theme_location' => 'primary-mobile', 'menu_id' => 'mobile-menu' ) ); ?>
				</div>
				<?php
			}
		endif; //wp_nav_menu primary-mobile
	}
endif;

if ( ! function_exists( 'makesite_hd_close' ) ) :
	/**
	 * Close the header container
	 * @action makesite_header
	 * @since 1.0.0
	 */
	function makesite_hd_close() {
		?>
			</div><!-- .col-full -->
		</header><!-- #masthead -->
		<?php
	}
endif;
