<?php
/**
 * Footer functions
 * @action makesite_footer
 * @since 1.0.0
 *
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 *
 * @package makesite
 */

if ( ! function_exists( 'makesite_ft_navigation' ) ) :
	/**
	 * Outputs navigation menu in footer
	 * @action makesite_footer
	 * @since 1.0.0
	 */
	function makesite_ft_navigation() {
		if ( has_nav_menu( 'footer' ) ) {
			?>
			<nav id="footer-navigation" class="footer-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
			</nav><!-- #site-navigation -->
			<?php
		}
	}
endif;

if ( ! function_exists( 'makesite_ft_skiplinks' ) ) :
	/**
	 * Outputs skip links in footer
	 * @action makesite_footer
	 * @since 1.0.0
	 */
	function makesite_ft_skiplinks() {
		$skip2contnt = esc_html__( 'Skip to content', 'makesite' )
		?>
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'makesite' ); ?></a>
		<?php
	}
endif;

if ( ! function_exists( 'makesite_ft_info' ) ) :
	/**
	 * Outputs site branding in footer
	 * @action makesite_footer
	 * @since 1.0.0
	 */
	function makesite_ft_info() {
		$designer_link = '<a href="' . MS_SITE  . '" title="WordPress Themes & Plugins by WPDevelopment">WPDevelopment</a>';
		$designer = '<br>' . sprintf( esc_html__( '%1$s designed by %2$s.', 'makesite' ), 'makesite', $designer_link );
		$designer = apply_filters( 'makesite_ft_designer', $designer );
		?>
		<div class="site-info">
			&copy; <?php bloginfo( 'name' ); ?>
			<?php echo $designer ?>
		</div><!-- .site-info -->
		<?php
	}
endif;
