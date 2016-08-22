<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

/**
 * Renders a theme template
 * @param string $content Creates content hook like content_{$content}
 */
function makesite( $content = '' ) {
	define( 'MS_CONTENT', $content );
	?>

	<?php get_header( MS_CONTENT ); ?>

	<div id="content" class="site-content container">

		<?php makesite_content(); ?>

		<?php get_sidebar( MS_CONTENT ); ?>

	</div><!-- #content -->

	<?php get_footer( MS_CONTENT ); ?>
	<?php
}

/**
 * Renders a theme template
 */
function makesite_content() {
	$hook = MS_CONTENT ? 'content_' . MS_CONTENT : 'content';
	?>
	<div id="primary" class="content-area">
			<?php
			/**
			 * Makesite render content
			 * @hook action makesite_content
			 * @uses makesite_ct_init()
			 */
			ms_do_action(
				$hook,
				'<main id="main" class="site-main" role="main">',
				'</main><!-- #main -->'
				);
			?>
	</div><!-- #primary -->
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
	$tag  = "makesite_$tag";

	if ( ! has_filter( $tag ) ) {
		return;
	}

	echo apply_filters( "{$tag}_before", $before );
	do_action_ref_array( $tag, $args );
	echo apply_filters( "{$tag}_after", $after );
}

/**
 * @param string $tag Tag to hook function to `makesite_` prepended automatically
 * @param callable $function_to_add
 * @param int $priority
 * @param int $accepted_args
 * @since 1.0.0
 */
function ms_hook( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
	add_filter( 'makesite_' . $tag, $function_to_add, $priority, $accepted_args );
}


/**
 * Minify HTML
 * @param array $out Data with keys for user type to output
 * @param bool $echo Shall we echo output?
 * @return string User type | User output if specified
 * @since 1.0.0
 */
function ms_user( $out = array(), $echo = true ) {
	$user_type = get_option( 'ms_user', 'creative' );

	if ( isset( $out[ $user_type ] ) ) {
		if ( $echo ) {
			echo $out[ $user_type ];
		}
		return $out[ $user_type ];
	}

	return $user_type;
}
