<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package makesite
 */

/**
 * Minify HTML
 * @param string $html HTML to minify
 * @return string Minified HTML
 * @since 1.0.0
 */
function ms_minify( $html ) {
	$html = str_replace( array( "\n", "\t", ), '', $html );
	return $html;
}


/**
 * Registers functions used throughout the theme
 * @package makesite
 * @since 1.0.0
 */
function ms_get_fonts( $data = null ) {
	$google_fonts = array(
		'Abel' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Amatic SC' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Arimo' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,cyrillic,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Arvo' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Bevan' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Bitter' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Black Ops One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Boogaloo' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Bree Serif' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Calligraffitti' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Cantata One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Cardo' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin,greek-ext,greek,latin-ext',
			'type'			=> 'serif',
		),
		'Changa One' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Cherry Cream Soda' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Chewy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Comfortaa' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin,cyrillic-ext,greek,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'Coming Soon' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Covered By Your Grace' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Crafty Girls' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Crete Round' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Crimson Text' => array(
			'styles' 		=> '400,400italic,600,600italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Cuprum' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Dancing Script' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Dosis' => array(
			'styles' 		=> '400,200,300,500,600,700,800',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Droid Sans' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Droid Serif' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Francois One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Fredoka One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'The Girl Next Door' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Gloria Hallelujah' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Happy Monkey' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Indie Flower' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Josefin Slab' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,600,700,700italic,600italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Judson' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Kreon' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Lato' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,700,700italic,900,900italic',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Lato Light' => array(
			'parent_font' => 'Lato',
			'styles'      => '300',
		),
		'Leckerli One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Lobster' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,cyrillic-ext,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'Lobster Two' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Lora' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Luckiest Guy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Merriweather' => array(
			'styles' 		=> '400,300,900,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Metamorphous' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Montserrat' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Noticia Text' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,vietnamese,latin-ext',
			'type'			=> 'serif',
		),
		'Nova Square' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Nunito' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Old Standard TT' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Open Sans' => array(
			'styles' 		=> '300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
			'character_set' => 'latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Open Sans Condensed' => array(
			'styles' 		=> '300,300italic,700',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,greek,vietnamese,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Open Sans Light' => array(
			'parent_font' => 'Open Sans',
			'styles'      => '300',
		),
		'Oswald' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Pacifico' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Passion One' => array(
			'styles' 		=> '400,700,900',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Patrick Hand' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,vietnamese,latin-ext',
			'type'			=> 'cursive',
		),
		'Permanent Marker' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Play' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin,cyrillic-ext,cyrillic,greek-ext,greek,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Playfair Display' => array(
			'styles' 		=> '400,400italic,700,700italic,900italic,900',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'serif',
		),
		'Poiret One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'PT Sans' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'PT Sans Narrow' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'PT Serif' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,cyrillic',
			'type'			=> 'serif',
		),
		'Raleway' => array(
			'styles' 		=> '400,100,200,300,600,500,700,800,900',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Raleway Light' => array(
			'parent_font' => 'Raleway',
			'styles'      => '300',
		),
		'Reenie Beanie' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Righteous' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Roboto' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic',
			'character_set' => 'latin,cyrillic-ext,latin-ext,cyrillic,greek-ext,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Roboto Condensed' => array(
			'styles' 		=> '400,300,300italic,400italic,700,700italic',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,cyrillic,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Roboto Light' => array(
			'parent_font' => 'Roboto',
			'styles'      => '100',
		),
		'Rock Salt' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Rokkitt' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Sanchez' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Satisfy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Schoolbell' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Shadows Into Light' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Source Sans Pro' => array(
			'styles' 		=> '400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Source Sans Pro Light' => array(
			'parent_font' => 'Source Sans Pro',
			'styles'      => '300',
		),
		'Special Elite' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Squada One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Tangerine' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Ubuntu' => array(
			'styles' 		=> '400,300,300italic,400italic,500,500italic,700,700italic',
			'character_set' => 'latin,cyrillic-ext,cyrillic,greek-ext,greek,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Unkempt' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Vollkorn' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Walter Turncoat' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Yanone Kaffeesatz' => array(
			'styles' 		=> '400,200,300,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
	);

	if ( $data ) {
		return apply_filters( 'ms_fonts', $google_fonts );
	}

	$fonts = array_keys( $google_fonts );
	return array_combine( $fonts, $fonts );
}

/** Admin notices */
if ( ! function_exists( 'ms_admin_notices' ) ) {
	/**
	 * Adds notice to output in next admin_notices actions call
	 *
	 * @param string $id Unique id for pootle page builder message
	 * @param string $message
	 * @param string $type Standard WP admin notice types supported defaults 'updated'
	 */
	function ms_add_admin_notice( $id, $message, $type = 'updated' ) {

		$notices = get_option( 'ms_admin_notices', array() );

		$notices[ $id ] = array(
			'type'    => $type,
			'message' => $message,
		);

		update_option( 'ms_admin_notices', $notices );
	}

	/**
	 * Outputs admin notices
	 * @action admin_notices
	 * @since 0.1.0
	 */
	function ms_admin_notices() {

		$notices = get_option( 'ms_admin_notices', array() );

		delete_option( 'ms_admin_notices' );

		if ( 0 < count( $notices ) ) {
			$html = '';
			foreach ( $notices as $k => $v ) {
				$html .= '<div id="' . esc_attr( $k ) . '" class="fade ' . esc_attr( $v['type'] ) . '">' . wpautop( $v['message'] ) . '</div>' . "\n";
			}
			echo $html;
		}
	}

	add_action( 'admin_notices', 'ms_admin_notices' );
}

/** Prioritizing an array */
if ( ! function_exists( 'ms_prioritize_array' ) ) {
	/**
	 * Compares priority
	 *
	 * @param array $a
	 * @param array $b
	 *
	 * @return bool
	 */
	function ms_priority_cmp( $a, $b ) {
		return $a['priority'] > $b['priority'];
	}

	/**
	 * Compares priority
	 *
	 * @param array $arr
	 *
	 * @uses ms_priority_cmp
	 * @return bool
	 */
	function ms_prioritize_array( &$arr ) {
		$i = 0;
		foreach ( $arr as $k => $v ) {
			if ( empty( $arr[ $k ]['priority'] ) ) {
				$arr[ $k ]['priority'] = 10 + ( 0.0001 * $i ++ );
			}
			$arr[ $k ]['id'] = $k;
		}
		uasort( $arr, 'ms_priority_cmp' );
	}
}


if ( ! function_exists( 'ms_stringify_prop_val' ) ) {
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
	function ms_stringify_prop_val( $data, $args = array() ) {

		if ( empty( $data ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'before'       => '',
				'after'        => '',
				'prop_glue'    => ' ',
			)
		);

		return
			$args['before'] .
			implode( $args['prop_glue'], ms_prop_val_array_format( $data, $args ) ) .
			$args['after'];
	}
	/**
	 * Converts attributes array into html attributes string
	 *
	 * @param array $data Associative ( multidimensional ) array attributes
	 * @param array $args {
	 *     Arguments for output
	 *
	 * @type string $before_prop Prefixed to property, Default '',
	 * @type string $before_value Between property and value, Default '="',
	 * @type string $after_value After the value, Default '" ',
	 * @type string $value_glue Implodes the array values, Default ' ',
	 * }
	 * @return string HTML attributes
	 */
	function ms_prop_val_array_format( $data, $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'before_prop'  => '',
				'before_value' => '="',
				'after_value'  => '"',
				'value_glue'   => ' ',
			)
		);
		$attr_data = array();
		foreach ( $data as $property => $value ) {
			if ( is_array( $value ) ) {
				$value = implode( $args['value_glue'], array_unique( $value ) );
			}
			$attr_data[] = $args['before_prop'] . $property . $args['before_value'] . $value . $args['after_value'];
		}
		return $attr_data;
	}
}

if ( ! function_exists( 'ms_make_id' ) ) {
	/**
	 * Gets id form title replacing non alpha numeric chars into $sep
	 *
	 * @param string $title The text to convet into id
	 * @param string $sep Word separator defaults '-'
	 *
	 * @return string
	 */
	function ms_make_id( $title, $sep = '-' ) {
		$title = strtolower( $title );

		return (string) preg_replace( '/[^A-z0-9]/', $sep, $title );
	}
}

if ( ! function_exists( 'ms_minify_html' ) ) {

	/**
	 * Minify HTML
	 * @param string $html HTML to minify
	 * @return string Minified HTML
	 * @since 1.0.0
	 */
	function ms_minify_html( $html ) {
		$html = str_replace( array( "\n", "\t", ), '', $html );
		return $html;
	}
}

if ( ! function_exists( 'ms_array_val' ) ) {
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
	function ms_array_value( $array, $key, $default = null, $format = '%s' ) {
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

if ( ! function_exists( 'ms_get_option' ) ) {
	/**
	 * @param string $option_group Menu slug to get options from
	 * @param string $option The key of the field
	 * @param mixed $default Default if not set
	 *
	 * @return mixed Setting or $default
	 */
	function ms_get_option( $option_group, $option, $default = null ) {
		$options = get_option( $option_group, array() );

		if ( ! isset( $options[ $option ] ) ) {
			$options[ $option ] = $default;
		}

		/** This filter is documented in wp-includes/theme.php */
		return apply_filters( "ms_get_option{$option_group}", $options[ $option ], $option );
	}
}

if ( ! function_exists( 'ms_is_assoc' ) ) {
	/**
	 * Checks if an array is associative array
	 * @param array $arr Array to check
	 * @return bool
	 */
	function ms_is_assoc( $arr ) {
		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}
}