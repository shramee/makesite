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
				array(
					'tag'   => 'main',
					'attrs' => array(
						'id'    => "main",
						'class' => "site-main",
						'role'  => "main",
					),
				)
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
 * @param array $func_args Arguments for functions hooked
 * @since 1.0.0
 */
function ms_do_action( $tag, $args, $func_args = array() ) {
	$tag = "makesite_$tag";

	ob_start();
	// The action hook for content
	do_action_ref_array( $tag, $func_args );

	$contents = ob_get_clean();

	if ( ! $contents ) {
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'attrs'  => array(),
			'before' => '',
			'after'  => '',
		)
	);

	$before = $args['before'];
	$after  = $args['after'];

	if ( ! empty( $args['tag'] ) ) {
		$args['attrs']['class'] = ! empty( $args['attrs']['class'] ) ? explode( ' ', $args['attrs']['class'] ) : $args['attrs']['class'];

		/**
		 * Dynamic hook to filter attributes of wrapping element
		 * Dynamic part is the hook tag supplied
		 *
		 * @param array $attrs Attributes
		 */
		$attrs = apply_filters( "{$tag}_attrs", $args['attrs'] );

		$before = "<$args[tag] " . ms_stringify_prop_val( $attrs ) . ">$before";
		$after  = "$after</$args[tag]>";
	}

	/**
	 * Dynamic hook to filter html for opening wrapping element(s)
	 * Dynamic part is the hook tag supplied
	 *
	 * @param array $attrs Attributes
	 */
	echo apply_filters( "{$tag}_before", $before );

	echo $contents;

	/**
	 * Dynamic hook to filter html for closing wrapping element(s)
	 * Dynamic part is the hook tag supplied
	 *
	 * @param array $attrs Attributes
	 */
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
