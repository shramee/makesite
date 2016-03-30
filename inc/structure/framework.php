<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

/**
 * Renders a theme template
 */
function makesite() {
	?>
	<?php get_header(); ?>

	<div id="content" class="site-content col-full">
		<?php
		/**
		 * Makesite render content
		 * @hook action makesite_content
		 * @hooked makesite_ct_open
		 * @hooked makesite_ct_loop
		 * @hooked makesite_ct_close
		 */
		ms_do_action(
			'content',
			'<div id="primary" class="content-area"><main id="main" class="site-main" role="main">',
			'</main><!-- #main --></div><!-- #primary -->'
		);
		get_sidebar()
		?>
	</div><!-- #content -->
	<?php get_footer(); ?>
	<?php
}

/**
 * Outputs HTML before and after the action if it has any functions hooked to it.
 * @param string $tag Tag for hook
 * @param string $before HTML before hook
 * @param string $after HTML after hook
 * @param array $args Arguments for functions hooked
 * @since 1.0.0
 */
function ms_do_action( $tag, $before = '', $after = '', $args = array() ) {
	$tag  = 'makesite_' . $tag;

	if ( ! has_filter( $tag ) ) {
		return;
	}

	echo $before;
	do_action_ref_array( $tag, $args );
	echo $after;
}

/**
 * @param array $tag Tag to hook function to `makesite_` prepended automatically
 * @param callable $function_to_add
 * @param int $priority
 * @param int $accepted_args
 * @since 1.0.0
 */
function ms_hook( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
	add_filter( 'makesite_' . $tag, $function_to_add, $priority, $accepted_args );
}