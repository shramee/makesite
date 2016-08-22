<?php
/**
 * Adds css for customizer options
 * @package makesite
 * @since 1.0.0
 */

class Makesite_Design_Css extends Makesite_Design_Css_Fields {

	/** @var Makesite_Design_Css Instance */
	protected static $instance;

	/** @var array Styles data */
	protected $css = '';

	/** @var string Classes to add to body */
	protected $body_classes = '';

	/** @var string Google fonts url */
	protected $gf_url = '';

	/** @var array Google fonts to load */
	protected $gf_load  = array();

	/** @var array Google fonts */
	protected $gf_data;

	/**
	 * Returns instance of Makesite_Design_Css
	 * @return Makesite_Design_Css
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function css() {
		return Makesite_Design_Css::instance()->css;
	}

	public static function body_classes() {
		return Makesite_Design_Css::instance()->body_classes;
	}

	public static function gf_url() {
		return Makesite_Design_Css::instance()->gf_url;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->gf_data = ms_get_fonts( 'data' );

		if ( is_customize_preview() ) {
			$setting = $this->live_settings();
		} else {
			$setting = get_option( 'makesite_setting', array(
				'body_classes' => '',
				'css' => '',
				'gf_url' => '',
			) );
		}

		foreach ( $setting as $id => $set ) {
			$this->$id = $set;
		}
	}

	/**
	 * Generates CSS data from settings
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @since 1.0.0
	 */
	protected function process_settings() {
		$styles = '';

		$ms_fields = Makesite_Design::fields();
		foreach ( $ms_fields as $settings_group => $options ) {
			foreach( $options as $id => $f ) {

				$f['default'] = empty( $f['default'] ) ? '' : $f['default'];

				//Getting setting in a var
				$setting = get_option( $id, $f['default'] );

				if ( $this->is_field_css( $setting, $f ) ) {
					$styles .= $this->field_css(  $setting, $f['output'], $f );
				}
			}
		}
		$this->css = $styles;
	}

	protected function is_field_css( $setting, $f ) {

		if ( empty( $setting ) )
			return false;

		if ( ! empty( $f['body_class'] ) )
			$this->body_classes .= sprintf( $f['body_class'], $setting );

		if ( empty( $f['output'] ) )
			return false;

		return true;
	}

	/**
	 * Outputs CSS from CSS data
	 * @action wp_head
	 * @uses Makesite_Design_Css::$styles
	 * @since 1.0.0
	 */
	protected function live_settings() {
		if ( empty( $this->css ) ) {
			$this->process_settings();
		}
		return apply_filters( 'makesite_design_components', array(
			'body_classes' => $this->body_classes,
			'css' => $this->css,
			'gf_url' => $this->generate_gf_url(),
		) );
	}

	public function save_settings(  ) {
		$makesite = $this->live_settings();
		update_option( 'makesite_setting', $makesite );
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
			$load_fonts[] = $font . ':' . implode( ':', $weight );

		if ( $load_fonts )
			return '//fonts.googleapis.com/css?family=' . join( '%7C', $load_fonts );

		return '';
	}

	/**
	 * Processes gf_data
	 * @since 1.0.0
	 */
	public function process_google_fonts() {
		foreach( $this->gf_load as $font => $weight ) {
			if ( 'Open Sans Condensed' == $font ) {
				$this->gf_load[ $font ] = array( '300' );
			} elseif ( strpos( $font, ' Light' ) ) {
				$this->gf_load[ str_replace( ' Light', '', $font ) ][] = '300';
			}
		}
	}
}