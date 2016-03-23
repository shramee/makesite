<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */
if ( ! function_exists( 'makesite_sb_open' ) ) :
	/**
	 * Opens the sidebar container
	 * @action makesite_sidebar - 7
	 * @since 1.0.0
	 */
	function makesite_sb_open() {
		?>
		<aside id="secondary" class="widget-area" role="complementary">
		<?php
	}
endif;

if ( ! function_exists( 'makesite_sb_widgets' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_sb_widgets( $sidebar_active ) {
		if ( $sidebar_active ) {
			dynamic_sidebar( 'sidebar-1' );
		}
	}
endif;

if ( ! function_exists( 'makesite_sb_close' ) ) :
	/**
	 * Close the sidebar container
	 * @action makesite_sidebar - 97
	 * @since 1.0.0
	 */
	function makesite_sb_close() {
		?>
		</aside><!-- #secondary -->
		<?php
	}
endif;
