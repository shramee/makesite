<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */
if ( ! function_exists( 'makesite_slide_ins' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @param bool $sidebar_active
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_slide_ins() {

		$left_slide_in = is_active_sidebar( 'left-slide' );

		/**
		 * Hide or show the sidebar
		 * @hook filter makesite_show_sidebar
		 */
		$show_slidein = apply_filters( 'makesite_show_left_slide_in', $left_slide_in );

		// If show sidebar is falsy, return
		if ( $show_slidein ) {

			/**
			 * Makesite render sidebar
			 * @hook action makesite_sidebar
			 * @param bool $left_slide_in Is slide-left active
			 * @hooked makesite_lsi_widgets - 25
			 */
			ms_do_action(
				'left_slide_in',
				array(
					'tag'    => 'aside',
					'attrs'  => array(
						'id'    => "left-slide-in",
						'class' => "slide-in left-slide-in",
						'role'  => "complementary",
					),
					'before' => '<div class="container">',
					'after'  => '</div><!-- .container -->',
				),
				array( $left_slide_in )
			);

		}

		$right_slide_in = is_active_sidebar( 'right-slide' );

		/**
		 * Hide or show the sidebar
		 * @hook filter makesite_show_sidebar
		 */
		$show_slidein = apply_filters( 'makesite_show_right_slide_in', $right_slide_in );

		// If show sidebar is falsy, return
		if ( $show_slidein ) {

			/**
			 * Makesite render sidebar
			 * @hook action makesite_sidebar
			 * @param bool $right_slide_in Is slide-right active
			 * @hooked makesite_rsi_widgets - 25
			 */
			ms_do_action(
				'right_slide_in',
				array(
					'tag'    => 'aside',
					'attrs'  => array(
						'id'    => "right-slide-in",
						'class' => "slide-in right-slide-in",
						'role'  => "complementary",
					),
					'before' => '<div class="container">',
					'after'  => '</div><!-- .container -->',
				),
				array( $right_slide_in )
			);

		}
	}
endif;

if ( ! function_exists( 'makesite_lsi_widgets' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @param bool $slide_in_active
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_lsi_widgets( $slide_in_active ) {
		if ( $slide_in_active ) {
			echo apply_filters(
				'left_slide_in_toggle',
				'<a class="slide-in-toggle" data-toggle-class data-toggle-target=".slide-in" href="javascript:0">' .
				'<i class="fa fa-chevron-right"></i>' .
				'<span class="screen-reader-text">Open left slide</span></a>'
			);
			?>
			<div class="overlay" data-toggle-class data-toggle-target=".slide-in"></div>
			<?php
			dynamic_sidebar( 'left-slide' );
		}
	}
endif;


if ( ! function_exists( 'makesite_rsi_widgets' ) ) :
	/**
	 * Outputs skip links in sidebar
	 * @param bool $slide_in_active
	 * @action makesite_sidebar - 25
	 * @since 1.0.0
	 */
	function makesite_rsi_widgets( $slide_in_active ) {
		if ( $slide_in_active ) {
			echo apply_filters(
				'right_slide_in_toggle',
				'<a class="slide-in-toggle" data-toggle-class data-toggle-target=".slide-in" href="javascript:0">' .
				'<i class="fa fa-chevron-left"></i>' .
				'<span class="screen-reader-text">Open right slide</span></a>'
			);
			?>
			<div class="overlay" data-toggle-class data-toggle-target=".slide-in"></div>
			<?php
			dynamic_sidebar( "right-slide" );
		}
	}
endif;
