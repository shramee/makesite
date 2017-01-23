<?php
/**
 * @developer shramee.me <me@shramee.me>
 */
if ( ! function_exists( 'makesite_sb_widgets' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @param bool $sidebar_active
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_sb_widgets( $sidebar_active ) {
		if ( $sidebar_active ) {
			dynamic_sidebar( "sidebar-1" );
		}
	}
endif;
if ( ! function_exists( 'makesite_sb2_widgets' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @param bool $sidebar_active
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_sb2_widgets( $sidebar_active ) {
		if ( $sidebar_active ) {
			dynamic_sidebar( "sidebar-2" );
		}
	}
endif;
