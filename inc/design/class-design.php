<?php

/**
 * Class Makesite_Design
 * Initiate Makesite design
 * @property-read string $css Site CSS
 * @property-read string $body_class Classes to apply to body
 * @property-read string $gf_url URL to call in google fonts used
 */
class Makesite_Design extends Makesite_Design_Fields_Css {

	/** @var Makesite_Design Instance */
	protected static $instance;

	/**
	 * Get design fields data
	 * @return array Design fields data
	 */
	public static function fields() {
		return ( include 'design-fields.php' );
	}

	/** @var Makesite_Design_Customizer_Register Instance */
	protected $admin;

	/**
	 * Magic __get to access protected properties
	 * @param string $name Property
	 * @return mixed Property $name of $this or false
	 */
	public function __get( $name ) {
		if ( isset( $this->$name ) )
			return $this->$name;

		return false;
	}

	/**
	 * Returns instance of Makesite_Admin_Customizer
	 * @return Makesite_Design Instance
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( Makesite_Design::$instance ) ) {
			Makesite_Design::$instance = new Makesite_Design();
		}

		return Makesite_Design::$instance;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {
		global $wp_customize;

		if ( $wp_customize instanceof WP_Customize_Manager ) {
			$this->admin = Makesite_Design_Customizer_Register::instance();
		}

		$this->gf_data = makesite_get_fonts( 'data' );
		$this->set_properties();

		add_action( 'customize_save_after', array( $this, 'save_settings' ) );
		if ( is_customize_preview() ) {
			add_action( 'wp', array( $this, 'set_live_properties' ) );
		}
	}

	/**
	 * Sets Makesite_Design properties
	 * @uses Makesite_Design::$styles
	 * @since 1.0.0
	 */
	public function set_live_properties() {
		$setting = $this->live_settings();

		foreach ( $setting as $id => $set ) {
			$this->$id = $set;
		}
	}

	/**
	 * Sets Makesite_Design properties
	 * @uses Makesite_Design::$styles
	 * @since 1.0.0
	 */
	public function set_properties() {
		$setting = get_option( 'makesite_setting', array() );

		foreach ( $setting as $id => $set ) {
			$this->$id = $set;
		}
	}

	/**
	 * Outputs CSS from CSS data
	 * @action wp_head
	 * @uses Makesite_Design::$styles
	 * @since 1.0.0
	 */
	protected function live_settings() {
		$this->process_settings();

		return apply_filters( 'makesite_design_components', array(
			'body_class' => $this->body_class,
			'css' => $this->css,
			'gf_url' => $this->generate_gf_url(),
		) );
	}

	/**
	 * Generates CSS data from settings
	 * @action wp
	 * @uses Makesite_Design::$styles, Makesite_Design::$gf_load
	 * @since 1.0.0
	 */
	protected function process_settings() {
		$styles = '';

		$makesite_fields = Makesite_Design::fields();
		foreach ( $makesite_fields as $settings_group => $options ) {
			foreach( $options as $id => $f ) {
				$styles .= $this->process_setting( $id, $f );
			}
		}
		$this->css = $styles;
	}

	/**
	 * Generates google font from gf_data
	 * @return string google font url
	 * @since 1.0.0
	 */
	public function generate_gf_url() {
		$this->process_google_fonts();

		$load_fonts = array();

		foreach( $this->gf_load as $font => $weight )
			if ( ! empty( $font ) ) {
				$load_fonts[] = $font . ':' . implode( ',', $weight );
			}

		if ( $load_fonts )
			return '//fonts.googleapis.com/css?family=' . join( '|', $load_fonts );

		return '';
	}

	/**
	 * Processes gf_data
	 * @since 1.0.0
	 */
	public function process_google_fonts() {
		foreach( $this->gf_load as $font => &$weight ) {
			if ( 'Open Sans Condensed' == $font ) {
				$this->gf_load[ $font ] = array( '300' => 1 );
			} elseif ( strpos( $font, ' Light' ) ) {
				$this->gf_load[ str_replace( ' Light', '', $font ) ]['300'] = 1;
			}

			$this->gf_load[ $font ] = array_keys( $this->gf_load[ $font ] );
		}
		$this->gf_load = apply_filters( 'makesite_google_fonts', $this->gf_load );
	}

	public function save_settings(  ) {
		$makesite = $this->live_settings();
		update_option( 'makesite_setting', $makesite );
	}
}

new WP_Widget_Search();