<?php
/**
 * makesite Theme Customizer.
 *
 * @package makesite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function makesite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'makesite_customize_register' );


/**
 * Set up the WordPress core custom header feature.
 *
 * @uses makesite_header_style()
 */
function makesite_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'makesite_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'makesite_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'makesite_custom_header_setup' );

if ( ! function_exists( 'makesite_header_style' ) ) {
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see makesite_custom_header_setup().
	 */
	function makesite_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
		 */
		if ( HEADER_TEXTCOLOR === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			<?php
				// Has the text been hidden?
				if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}

			<?php
				// If the user has set a custom color for the text use that.
				else :
			?>
			.site-title a,
			.site-description {
				color: # <?php echo esc_attr( $header_text_color ); ?>;
			}

			<?php endif; ?>
		</style>
		<?php
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function makesite_customize_preview_js() {
	wp_enqueue_script( 'makesite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'makesite_customize_preview_js' );
