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
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<?php esc_html_e( 'Primary Menu', 'makesite' ); ?>
			</button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		<?php
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
		</header><!-- #masthead -->
		<?php
	}
endif;
