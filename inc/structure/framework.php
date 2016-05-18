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

	<div id="content" class="site-content col-full">

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

	echo apply_filters( "makesite_{$tag}_before", $before );
	do_action_ref_array( $tag, $args );
	echo apply_filters( "makesite_{$tag}_after", $after );
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

/** Admin notices */
if ( ! function_exists( 'wpd_admin_notices' ) ) {
	/**
	 * Adds notice to output in next admin_notices actions call
	 *
	 * @param string $id Unique id for pootle page builder message
	 * @param string $message
	 * @param string $type Standard WP admin notice types supported defaults 'updated'
	 */
	function wpd_add_admin_notice( $id, $message, $type = 'updated' ) {

		$notices = get_option( 'wpd_admin_notices', array() );

		$notices[ $id ] = array(
			'type'    => $type,
			'message' => $message,
		);

		update_option( 'wpd_admin_notices', $notices );
	}

	/**
	 * Outputs admin notices
	 * @action admin_notices
	 * @since 0.1.0
	 */
	function wpd_admin_notices() {

		$notices = get_option( 'wpd_admin_notices', array() );

		delete_option( 'wpd_admin_notices' );

		if ( 0 < count( $notices ) ) {
			$html = '';
			foreach ( $notices as $k => $v ) {
				$html .= '<div id="' . esc_attr( $k ) . '" class="fade ' . esc_attr( $v['type'] ) . '">' . wpautop( $v['message'] ) . '</div>' . "\n";
			}
			echo $html;
		}
	}

	add_action( 'admin_notices', 'wpd_admin_notices' );
}

/** Prioritizing an array */
if ( ! function_exists( 'wpd_prioritize_array' ) ) {
	/**
	 * Compares priority
	 *
	 * @param array $a
	 * @param array $b
	 *
	 * @return bool
	 */
	function wpd_priority_cmp( $a, $b ) {
		return $a['priority'] > $b['priority'];
	}

	/**
	 * Compares priority
	 *
	 * @param array $arr
	 *
	 * @uses wpd_priority_cmp
	 * @return bool
	 */
	function wpd_prioritize_array( &$arr ) {
		$i = 0;
		foreach ( $arr as $k => $v ) {
			if ( empty( $arr[ $k ]['priority'] ) ) {
				$arr[ $k ]['priority'] = 10 + ( 0.0001 * $i ++ );
			}
			$arr[ $k ]['id'] = $k;
		}
		uasort( $arr, 'wpd_priority_cmp' );
	}
}


if ( ! function_exists( 'wpd_stringify_prop_val' ) ) {
	/**
	 * Converts attributes array into html attributes string
	 *
	 * @param array $data Associative ( multidimensional ) array attributes
	 * @param array $args {
	 *     Arguments for output
	 *
	 * @type string $before Added before all property value pairs, Default '',
	 * @type string $after Added after all property value pairs, Default '',
	 * @type string $before_prop Prefixed to property, Default '',
	 * @type string $before_value Between property and value, Default '="',
	 * @type string $after_value After the value, Default '" ',
	 * @type string $value_glue Implodes the array values, Default ' ',
	 * @type string $prop_glue Implodes all property value pairs, Default ' ',
	 * }
	 * @return string HTML attributes
	 */
	function wpd_stringify_prop_val( $data, $args = array() ) {

		if ( empty( $data ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'before'       => '',
				'after'        => '',
				'before_prop'  => '',
				'before_value' => '="',
				'after_value'  => '"',
				'value_glue'   => ' ',
				'prop_glue'    => ' ',
			)
		);

		$attributes = $args['before'];

		$attr_data = array();
		foreach ( $data as $property => $value ) {
			if ( is_array( $value ) ) {
				$value = implode( $args['value_glue'], array_unique( $value ) );
			}

			$attr_data[] = $args['before_prop'] . $property . $args['before_value'] . $value . $args['after_value'];
		}
		$attributes .= implode( $args['prop_glue'], $attr_data );

		return $attributes . $args['after'];
	}
}

if ( ! function_exists( 'wpd_make_id' ) ) {
	/**
	 * Gets id form title replacing non alpha numeric chars into $sep
	 *
	 * @param string $title The text to convet into id
	 * @param string $sep Word separator defaults '-'
	 *
	 * @return string
	 */
	function wpd_make_id( $title, $sep = '-' ) {
		$title = strtolower( $title );

		return (string) preg_replace( '/[^A-z0-9]/', $sep, $title );
	}
}

if ( ! function_exists( 'wpd_minify_html' ) ) {

	/**
	 * Minify HTML
	 * @param string $html HTML to minify
	 * @return string Minified HTML
	 * @since 1.0.0
	 */
	function wpd_minify_html( $html ) {
		$html = str_replace( array( "\n", "\t", ), '', $html );
		return $html;
	}
}

if ( ! function_exists( 'wpd_array_val' ) ) {
	/**
	 * Returns value from from array if key exists
	 *
	 * @param array $array The text to convert into id
	 * @param string $key Key of the value
	 * @param mixed $default returned if key doesn't exist
	 * @param string $format To return value in a format
	 *
	 * @return mixed Value or Formatted value if string
	 */
	function wpd_array_value( $array, $key, $default = null, $format = '%s' ) {
		if ( isset( $array[ $key ] ) ) {
			$value = $array[ $key ];
		} else {
			$value = $default;
		}

		if ( ! empty( $value ) ) {
			if ( is_string( $value ) ) {
				return sprintf( $format, $value );
			} else {
				return $value;
			}
		} else {
			return null;
		}
	}
}

if ( ! function_exists( 'wpd_get_option' ) ) {
	/**
	 * @param string $option_group Menu slug to get options from
	 * @param string $option The key of the field
	 * @param mixed $default Default if not set
	 *
	 * @return mixed Setting or $default
	 */
	function wpd_get_option( $option_group, $option, $default = null ) {
		$options = get_option( $option_group, array() );

		if ( ! isset( $options[ $option ] ) ) {
			$options[ $option ] = $default;
		}

		/** This filter is documented in wp-includes/theme.php */
		return apply_filters( "wpd_get_option{$option_group}", $options[ $option ], $option );
	}
}

if ( ! function_exists( 'wpd_is_assoc' ) ) {
	/**
	 * Checks if an array is associative array
	 * @param array $arr Array to check
	 * @return bool
	 */
	function wpd_is_assoc( $arr ) {
		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}
}